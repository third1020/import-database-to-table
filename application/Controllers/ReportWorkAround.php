<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App;
use App\Models\RequestModel;
use App\Models\ProblemsModel;
use App\Models\incidentModel;
use App\Models\EquipmentModel;
use App\Models\ContactModel;
use App\Models\ImpactModel;
use App\Models\PriorityModel;
use App\Models\UserModel;

class ReportWorkAround extends Controller {

  public function Report() {

    $data = array ();
    $data ['nav'] = view ( 'nav_message' );
    $this->request->isSecure ();
    $validation = \Config\Services::validation ();
    $problemsModel = new ProblemsModel ();
    $requestModel = new RequestModel ();
    $incidentModel = new incidentModel ();

    $pb = new App\Entities\ProblemsEntity ();




    foreach ( $problemsModel->get_max () as $key ) {

      $max_problems = $key->id;
    }

      $min_problems = 0;

    if(empty($max_problems)){

      $data ['content'] = view ( 'reportworkaround/report_workaround_message', [
          'validation' => $validation,
          'start_time' => null,
          'time' => null,
          'temp_join' => null,
          'end_time' => null,
          'problems' => null,
          'error' => "ข้อมูลตารางปัญหาว่างเปล่า"
      ] );

      return view ( 'welcome_message', $data );

    }

    $problems = $problemsModel->get_all_problems ( $max_problems, 0 );


    if ($this->request->getMethod ( true ) == "POST") {

      $start_time = $this->request->getPost ( 'start_time' );
      $end_time = $this->request->getPost ( 'end_time' );

      $new_start_time = date ( "Y/m/d H:i:s", strtotime ( $start_time ) );
      // $create_at = date("Y/m/d H:i:s", strtotime($request[0]->created_at));
      $new_end_time = date ( "Y/m/d H:i:s", strtotime ( $end_time ) );


        for($k = 0; $k <= $max_problems; $k ++) {
          if (! empty ( $problems [$k] )) {
            $create_at [$k] = date ( "Y/m/d H:i:s", strtotime ( $problems [$k]->created_at ) );

            if (! empty ( $problems [$k]->created_at )) {

              if ($create_at [$k] > $new_start_time && $create_at [$k] < $new_end_time) {

                $temp_problems [$k] = $problems [$k];

              }
            }
          }
        }

  for($k = 0; $k <= $max_problems; $k++) {

        $problemsModel->table('problems');
        $problemsModel->select('problems.*, equipment.id AS equipment, equipment.equipment_name,
                                            contact.id AS contact, contact.contact_name'
                                       );

        $problemsModel->join('equipment', 'equipment.id = problems.equipment_id');
        $problemsModel->join('contact', 'contact.id = problems.contact_id');

        $problemsModel->where(array('problems.id' => $k));
        $join = $problemsModel->get ();
        $join = $join->getResult ();
        $temp_join[$k] = $join;

        }
        for($j = 0; $j <= $max_problems+1; $j++) {
          if(empty($temp_join[$j][0])){
            continue;
          }
          $create_at [$j] = date ( "Y/m/d H:i:s", strtotime ( $temp_join[$j][0]->created_at ) );

          if ($create_at [$j]  > $new_start_time && $create_at [$j]  < $new_end_time) {

          

            $time[$j] = $temp_join[$j][0];

          }

        }




        $problems = 0;
        $cancel_problems = 0;
        $access_problems = 0;
        $comfirm_problems = 0;
        $workaround_problems = 0;


        if (! empty ( $time )) {

        $data ['content'] = view ( 'reportworkaround/report_workaround_message', [
            'validation' => $validation,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'time' => $time,
            'temp_join' => $temp_join,
            'problems' => $problems,

        ] );

        return view ( 'welcome_message', $data );
      }else{

        $data ['content'] = view ( 'reportworkaround/report_workaround_message', [
            'validation' => $validation,
            'start_time' => $start_time,
            'time' => null,
            'temp_join' => $temp_join,
            'end_time' => $end_time,
            'problems' => $problems=0,
            'error' => "ไม่พบข้อมูลที่ต้องการ"
        ] );

        return view ( 'welcome_message', $data );
      }
    }

    $data ['content'] = view ( 'reportworkaround/report_workaround_message', [
        'validation' => $validation,
        'start_time' => null,
        'end_time' => null



    ] );

    return view ( 'welcome_message', $data );

  }



}
