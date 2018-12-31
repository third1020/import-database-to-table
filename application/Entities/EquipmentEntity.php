<?php namespace App\Entities;

use CodeIgniter\Entity;

class EquipmentEntity extends Entity
{
    protected $id;
    protected $remark;
    protected $equipment_name;
    protected $equipment_detail;
    protected $equipment_image;
    protected $created_by;
    protected $created_at;
    protected $updated_at;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @return mixed
     */
    public function getEquipment_name()
    {
        return $this->equipment_name;
    }

    /**
     * @return mixed
     */
    public function getEquipment_detail()
    {
        return $this->equipment_detail;
    }

    /**
     * @return mixed
     */
    public function getEquipment_image()
    {
        return $this->equipment_image;
    }

    /**
     * @return mixed
     */
    public function getCreated_by()
    {
        return $this->created_by;
    }

    /**
     * @return mixed
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $id
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * @param mixed $equipment_name
     */
    public function setEquipment_name($equipment_name)
    {
        $this->equipment_name = $equipment_name;
    }


    /**
     * @param mixed $equipment_detail
     */
    public function setEquipment_detail($equipment_detail)
    {
        $this->equipment_detail = $equipment_detail;
    }


    /**
     * @param mixed $equipment_image
     */
    public function setEquipment_image($equipment_image)
    {
        $this->equipment_img = $equipment_image;
    }


    /**
     * @param mixed $created_by
     */
    public function setCreated_by($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    function read($sFileName){

      // check if file exist and is readable (Darko Miljanovic)
      if(!is_readable($sFileName)) {
        $this->error = 1;
        return false;
      }

      $this->data = @file_get_contents($sFileName);
      if (!$this->data) {
        $this->error = 1;
        return false;
      }
      //echo IDENTIFIER_OLE;
      //echo 'start';
      if (substr($this->data, 0, 8) != IDENTIFIER_OLE) {
        $this->error = 1;
        return false;
      }
        $this->numBigBlockDepotBlocks = GetInt4d($this->data, NUM_BIG_BLOCK_DEPOT_BLOCKS_POS);
        $this->sbdStartBlock = GetInt4d($this->data, SMALL_BLOCK_DEPOT_BLOCK_POS);
        $this->rootStartBlock = GetInt4d($this->data, ROOT_START_BLOCK_POS);
        $this->extensionBlock = GetInt4d($this->data, EXTENSION_BLOCK_POS);
        $this->numExtensionBlocks = GetInt4d($this->data, NUM_EXTENSION_BLOCK_POS);

  /*
        echo $this->numBigBlockDepotBlocks." ";
        echo $this->sbdStartBlock." ";
        echo $this->rootStartBlock." ";
        echo $this->extensionBlock." ";
        echo $this->numExtensionBlocks." ";
        */
        //echo "sbdStartBlock = $this->sbdStartBlock\n";
        $bigBlockDepotBlocks = array();
        $pos = BIG_BLOCK_DEPOT_BLOCKS_POS;
       // echo "pos = $pos";
  $bbdBlocks = $this->numBigBlockDepotBlocks;

            if ($this->numExtensionBlocks != 0) {
                $bbdBlocks = (BIG_BLOCK_SIZE - BIG_BLOCK_DEPOT_BLOCKS_POS)/4;
            }

        for ($i = 0; $i < $bbdBlocks; $i++) {
              $bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
              $pos += 4;
        }


        for ($j = 0; $j < $this->numExtensionBlocks; $j++) {
            $pos = ($this->extensionBlock + 1) * BIG_BLOCK_SIZE;
            $blocksToRead = min($this->numBigBlockDepotBlocks - $bbdBlocks, BIG_BLOCK_SIZE / 4 - 1);

            for ($i = $bbdBlocks; $i < $bbdBlocks + $blocksToRead; $i++) {
                $bigBlockDepotBlocks[$i] = GetInt4d($this->data, $pos);
                $pos += 4;
            }

            $bbdBlocks += $blocksToRead;
            if ($bbdBlocks < $this->numBigBlockDepotBlocks) {
                $this->extensionBlock = GetInt4d($this->data, $pos);
            }
        }

       // var_dump($bigBlockDepotBlocks);

        // readBigBlockDepot
        $pos = 0;
        $index = 0;
        $this->bigBlockChain = array();

        for ($i = 0; $i < $this->numBigBlockDepotBlocks; $i++) {
            $pos = ($bigBlockDepotBlocks[$i] + 1) * BIG_BLOCK_SIZE;
            //echo "pos = $pos";
            for ($j = 0 ; $j < BIG_BLOCK_SIZE / 4; $j++) {
                $this->bigBlockChain[$index] = GetInt4d($this->data, $pos);
                $pos += 4 ;
                $index++;
            }
        }

  //var_dump($this->bigBlockChain);
        //echo '=====2';
        // readSmallBlockDepot();
        $pos = 0;
      $index = 0;
      $sbdBlock = $this->sbdStartBlock;
      $this->smallBlockChain = array();

      while ($sbdBlock != -2) {

        $pos = ($sbdBlock + 1) * BIG_BLOCK_SIZE;

        for ($j = 0; $j < BIG_BLOCK_SIZE / 4; $j++) {
          $this->smallBlockChain[$index] = GetInt4d($this->data, $pos);
          $pos += 4;
          $index++;
        }

        $sbdBlock = $this->bigBlockChain[$sbdBlock];
      }


        // readData(rootStartBlock)
        $block = $this->rootStartBlock;
        $pos = 0;
        $this->entry = $this->__readData($block);

        /*
        while ($block != -2)  {
            $pos = ($block + 1) * BIG_BLOCK_SIZE;
            $this->entry = $this->entry.substr($this->data, $pos, BIG_BLOCK_SIZE);
            $block = $this->bigBlockChain[$block];
        }
        */
        //echo '==='.$this->entry."===";
        $this->__readPropertySets();

    }

    public function expose() {
      $var = get_object_vars($this);
      foreach ($var as &$value) {
        if (is_object($value) && method_exists($value,'getJsonData')) {
          $value = $value->getJsonData();
        }
      }
      return $var;
    }

}
