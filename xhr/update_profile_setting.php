<?php 
if ($f == "update_profile_setting") {
    if (isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] > 0 && Wo_CheckSession($hash_id) === true) {
        $Userdata = Wo_UserData($_POST['user_id']);
        if (!empty($Userdata['user_id'])) {
            $pattern = '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{1,100}' . '((:[0-9]{1,5})?\\/.*)?$/i';
            if (!empty($_POST['website'])) {
                if (!preg_match($pattern, $_POST['website'])) {
                    $errors[] = $error_icon . $wo['lang']['website_invalid_characters'];
                }
            }
            if (!empty($_POST['working_link'])) {
                if (!preg_match($pattern, $_POST['working_link'])) {
                    $errors[] = $error_icon . $wo['lang']['company_website_invalid'];
                }
            }
            if (strlen(Wo_Secure($_POST['about'])) > 200) {
                $errors[] = $error_icon . "Characters should not be exceed from 200.";
            }
            if (!is_numeric($_POST['relationship']) || empty($_POST['relationship'])) {
                $_POST['relationship'] = 0;
                Wo_DeleteMyRelationShip();
            }
            if (isset($_POST['relationship_user']) && is_numeric($_POST['relationship_user']) && $_POST['relationship_user'] > 0) {
                if (is_numeric($_POST['relationship']) && $_POST['relationship'] > 0 && $_POST['relationship'] <= 4) {
                    $relationship_user = Wo_Secure($_POST['relationship_user']);
                    $user              = Wo_Secure($wo['user']['id']);
                    if (!Wo_IsRelationRequestExists($user, $relationship_user, $_POST['relationship'])) {
                        $registration_data = array(
                            'from_id' => $user,
                            'to_id' => $relationship_user,
                            'relationship' => Wo_Secure($_POST['relationship']),
                            'active' => 0
                        );
                        $registration_id   = Wo_RegisterRelationship($registration_data);
                        if ($registration_id) {
                            $relationship_user_data  = Wo_UserData($relationship_user);
                            $notification_data_array = array(
                                'recipient_id' => $relationship_user,
                                'type' => 'added_u_as',
                                'user_id' => $wo['user']['id'],
                                'text' => $wo['lang']['relationship_request'],
                                'url' => 'index.php?link1=timeline&u=' . $relationship_user_data['username'] . '&type=requests'
                            );
                            Wo_RegisterNotification($notification_data_array);
                        }
                    }
                }
            }
            if (empty($errors)) {
                $Update_data = array(
                    'first_name' => Wo_Secure($_POST['first_name']) ,
                    'last_name' => Wo_Secure($_POST['last_name']),
                    'website' => $_POST['website'],
                    'about' => Wo_Secure($_POST['about']),
                    'working' => $_POST['working'],
                    'working_link' => $_POST['working_link'],
                    'address' => $_POST['address'],
                    'school' => $_POST['school'],
                    'relationship_id' => $_POST['relationship'],
                    'region_grew' => $_POST['region_grew'],
                    'region_currently' => $_POST['region_currently'],
                    'curr_fav_music_genre' => $_POST['curr_fav_music_genre'],
                    'all_time_fav_group' => $_POST['all_time_fav_group'],
                    'all_time_fav_solo_artist' => $_POST['all_time_fav_solo_artist'],
                    'all_time_fav_song' => $_POST['all_time_fav_song'],
                    'curr_fav_group' => $_POST['curr_fav_group'],
                    'curr_fav_song' => $_POST['curr_fav_song'],
                    'first_concert' => $_POST['first_concert'],
                    'last_concert' => $_POST['last_concert'],
                    'dream_concert' => $_POST['dream_concert'],
                    'idolized_growing' => $_POST['idolized_growing'],
                    'curr_sports_team' => $_POST['curr_sports_team'],
                    'current_favorite_athlete' => $_POST['current_favorite_athlete'],
                    'athlete_crush' => $_POST['athlete_crush'],
                    'curr_fav_solo_artist' => $_POST['curr_fav_solo_artist'],
                    'fav_all_band' => $_POST['fav_all_band'],
                    'fav_curr_band' => $_POST['fav_curr_band'],
                );
                $Update_data['relation_do_not_show'] = 0;
                if (!empty($_POST['relation_do_not_show']) && !empty($_POST['relation_do_not_show']) && $_POST['relation_do_not_show'] == 'on') {
                    $Update_data['relation_do_not_show'] = 1;
                }

                if (!empty($_POST['school']) && !empty($_POST['completed']) && $_POST['completed'] == 'on') {
                    $Update_data['school_completed'] = 1;
                }
                if (Wo_UpdateUserData($_POST['user_id'], $Update_data)) {
                    if($wo['user']['default_type'] == 0){
                        $another_profile = Wo_GetUserFromRefEmail($Userdata['email']);
                        $Update_data = array(
                            'website' => $_POST['website'],
                            'about' => Wo_Secure($_POST['about']),
                            'working' => $_POST['working'],
                            'working_link' => $_POST['working_link'],
                            'address' => $_POST['address'],
                            'school' => $_POST['school'],
                            'relationship_id' => $_POST['relationship'],
                            'region_grew' => $_POST['region_grew'],
                            'region_currently' => $_POST['region_currently'],
                            'generation' => $_POST['generation'],
                        );
                        $Update_data['relation_do_not_show'] = 0;
                        if (!empty($_POST['relation_do_not_show']) && !empty($_POST['relation_do_not_show']) && $_POST['relation_do_not_show'] == 'on') {
                            $Update_data['relation_do_not_show'] = 1;
                        }
                        Wo_UpdateRefUserData($another_profile['user_id'],$Update_data);
                    }
                    $field_data = array();
                    if (!empty($_POST['custom_fields'])) {
                        $fields = Wo_GetProfileFields('profile');
                        foreach ($fields as $key => $field) {
                            $name = $field['fid'];
                            if (isset($_POST[$name])) {
                                if (mb_strlen($_POST[$name]) > $field['length']) {
                                    $errors[] = $error_icon . $field['name'] . ' field max characters is ' . $field['length'];
                                }
                                $field_data[] = array(
                                    $name => $_POST[$name]
                                );
                            }
                        }
                    }
                    if (!empty($field_data)) {
                        $insert = Wo_UpdateUserCustomData($_POST['user_id'], $field_data);
                    }
                    if (empty($errors)) {
                        $data = array(
                            'status' => 200,
                            'first_name' => Wo_Secure($_POST['first_name']),
                            'last_name' => Wo_Secure($_POST['last_name']),
                            'message' => $success_icon . $wo['lang']['setting_updated']
                        );
                    }
                }
            }
        }
    }
    Wo_CleanCache();
    header("Content-type: application/json");
    if (isset($errors)) {
        echo json_encode(array(
            'errors' => $errors
        ));
    } else {
        echo json_encode($data);
    }
    exit();
}
