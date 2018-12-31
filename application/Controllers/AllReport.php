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

class AllReport extends Controller {

  public function Report() {

    $data = array ();
    $data ['nav'] = view ( 'nav_message' );
    $this->request->isSecure ();
    $validation = \Config\Services::validation ();
    $problemsModel = new ProblemsModel ();
    $requestModel = new RequestModel ();
    $incidentModel = new incidentModel ();

    $pb = new App\Entities\incidentEntity ();
if(empty($requestModel->get_max ()) || empty($problemsModel->get_max ()) || empty($incidentModel->get_max ())){

  $data ['content'] = view ( 'allreport/report_allreport_message', [
      'validation' => $validation,
      'start_time' => null,
      'end_time' => null,
      'error' => "ข้อมูลบางรายการว่างเปล่า"
  ] );

  return view ( 'welcome_message', $data );


}

    foreach ( $incidentModel->get_max () as $key ) {

      $max_incident = $key->id;
    }

      $min_incident = 0;


    foreach ( $problemsModel->get_max () as $key ) {

      $max_problems = $key->id;
    }

      $min_problems = 0;


    foreach ( $requestModel->get_max () as $key ) {

      $max_request = $key->id;
    }

      $min_request = 0;

   //
   // echo "<br>$max_incident</br>";
   // echo "<br>$max_problems</br>";
   // echo "<br>$max_request</br>";

    // echo $max_elements_per_page;
    $request = $requestModel->get_all_request ( $max_request, 0 );
    $problems = $problemsModel->get_all_problems ( $max_problems, 0 );
    $incident = $incidentModel->get_all_incident ( $max_incident, 0 );

    if ($this->request->getMethod ( true ) == "POST") {

      $start_time = $this->request->getPost ( 'start_time' );
      $end_time = $this->request->getPost ( 'end_time' );

      $new_start_time = date ( "Y/m/d H:i:s", strtotime ( $start_time ) );
      // $create_at = date("Y/m/d H:i:s", strtotime($request[0]->created_at));
      $new_end_time = date ( "Y/m/d H:i:s", strtotime ( $end_time ) );


      for($i = $min_incident; $i <= $max_incident; $i ++) {
        if (! empty ( $incident [$i] )) {
          $create_at [$i] = date ( "Y/m/d H:i:s", strtotime ( $incident [$i]->created_at ) );

          if (! empty ( $incident [$i]->created_at )) {

            if ($create_at [$i] > $new_start_time && $create_at [$i] < $new_end_time) {

              $temp_incident [$i] = $incident [$i];

            }
          }
        }
      }

      for($j = $min_request; $j <= $max_request; $j ++) {
        if (! empty ( $request [$j] )) {
          $create_at [$j] = date ( "Y/m/d H:i:s", strtotime ( $request [$j]->created_at ) );

          if (! empty ( $request [$j]->created_at )) {

            if ($create_at [$j] > $new_start_time && $create_at [$j] < $new_end_time) {

              $temp_request [$j] = $request [$j];


            }
          }
        }
      }
      

        for($k = $min_problems; $k <= $max_problems; $k ++) {
          if (! empty ( $problems [$k] )) {
            $create_at [$k] = date ( "Y/m/d H:i:s", strtotime ( $problems [$k]->created_at ) );

            if (! empty ( $problems [$k]->created_at )) {

              if ($create_at [$k] > $new_start_time && $create_at [$k] < $new_end_time) {

                $temp_problems [$k] = $problems [$k];

              }
            }
          }
        }

        $request = 0;
        $success = 0;
        $not_success = 0;

        $problems = 0;
        $cancel_problems = 0;
        $access_problems = 0;
        $comfirm_problems = 0;
        $workaround_problems = 0;

        $incident = 0;
        $cancel_incident = 0;
        $access_incident = 0;
        $comfirm_incident = 0;
        $workaround_incident = 0;

        if (! empty ( $temp_request )) {

          for($i = $min_request; $i <= $max_request; $i ++) {
            if( empty ( $temp_request [$i] )) {
              continue;
            }
            if (! empty ( $temp_request [$i] )) {
              $request ++;
            }
            if ($temp_request [$i]->request_status == 1) {
							$success ++;
						}

          }

          $not_success = $request-$success;
        }

          if (! empty ( $temp_problems )) {

            for($i = $min_problems; $i <= $max_problems; $i ++) {
              if( empty ( $temp_problems [$i] )) {
                continue;
              }
              if (! empty ( $temp_problems [$i] )) {
                $problems ++;
              }
              if (! empty ( $temp_problems [$i]->problems_status )) {
    						if ($temp_problems [$i]->problems_status == 1) {
    							$cancel_problems ++;
    						}
    						if ($temp_problems [$i]->problems_status == 2) {
    							$access_problems ++;
    						}
    						if ($temp_problems [$i]->problems_status == 3) {
    							$comfirm_problems ++;
    						}
    						if ($temp_problems [$i]->problems_status == 4) {
    							$workaround_problems ++;
    						}
    					}

            }

            // echo $problems;
          }


      if (! empty ( $temp_incident )) {

        for($i = $min_incident; $i <= $max_incident; $i ++) {
          if( empty ( $temp_incident [$i] )) {
            continue;
          }
          if (! empty ( $temp_incident [$i] )) {
            $incident ++;
          }
          if (! empty ( $temp_incident [$i]->incident_status )) {
            if ($temp_incident [$i]->incident_status == 1) {
              $cancel_incident ++;
            }
            if ($temp_incident [$i]->incident_status == 2) {
              $access_incident ++;
            }
            if ($temp_incident [$i]->incident_status == 3) {
              $comfirm_incident ++;
            }
            if ($temp_incident [$i]->incident_status == 4) {
              $workaround_incident ++;
            }
          }

        }

        // echo $incident;

        // echo $not_success;
        }

        if (! empty ( $temp_request ) || ! empty ( $temp_problems ) || ! empty ( $temp_incident )) {

        $data ['content'] = view ( 'allreport/report_allreport_message', [
            'validation' => $validation,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'request' => $request,
            'success' => $success,
            'not_success' => $not_success,

            'problems' => $problems,
            'cancel_problems' =>$cancel_problems,
            'access_problems' =>$access_problems,
            'comfirm_problems' =>$comfirm_problems,
            'workaround_problems' =>$workaround_problems,

            'incident' => $incident,
            'cancel_incident' =>$cancel_incident,
            'access_incident' =>$access_incident,
            'comfirm_incident' =>$comfirm_incident,
            'workaround_incident' =>$workaround_incident,
        ] );

        return view ( 'welcome_message', $data );
      }else{

        $data ['content'] = view ( 'allreport/report_allreport_message', [
            'validation' => $validation,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'request' => $request=0,
            'problems' => $problems=0,
            'incident' => $incident=0,
            'error' => "ไม่พบข้อมูลที่ต้องการ"
        ] );

        return view ( 'welcome_message', $data );
      }
    }

    $data ['content'] = view ( 'allreport/report_allreport_message', [
        'validation' => $validation,
        'start_time' => null,
        'end_time' => null



    ] );

    return view ( 'welcome_message', $data );

  }



}
