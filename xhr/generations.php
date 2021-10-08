<?php 
if ($f == 'generations') {
    $generation = Wo_CheckGeneration($_POST['year']);
    if($generation){
        $data = array(
            'status' => 200,
            'generation' => $generation['name']
        );
    }else{
        $data = array(
            'status' => 404,
            'generation' => "Not Found"
        );
    }
    header("Content-type: application/json");
    echo json_encode($data);
}
