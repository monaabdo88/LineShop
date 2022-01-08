<?php
/*
function to add new role
*/
if(! function_exists('add_role')){
    function add_role(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $role_name              = $_POST['role_name'];
        
            //check if role is already exists
            if(checkItem('role_name','roles',$role_name) == 1){
                $msg = show_msg('Error','This role is already exists');
            }else{
                //add new role to database
                $stmt = $con->prepare("INSERT INTO 
                    roles(role_name)
                    VALUES(:zrole_name)");
                $stmt->execute(array(
                    'zrole_name' 	=> $role_name
                ));
                //get row id
                $last_id = $con->lastInsertId();
                
                //check if permission added
                if(isset($_POST['permissions']))
                    //add role permissions code
                    role_permissions($last_id,$_POST['permissions']);
                // Echo Success Message
                $msg = show_msg('success',"Record Inserted Successsfully");
                
            }
            echo $msg;
            redirectPage('roles.php');
            
        }
    }
}
/*
function to update role
*/
if(! function_exists('update_role')){
    function update_role(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $role_name          = $_POST['role_name'];
            $id                 = $_POST['role_id'];
            //check if the new role role_name is exists in another role
            if(checkItemUp('role_name','roles',$role_name,$id) > 0){
                $msg = show_msg('Error','This role role_name is Already exists');
            }
            else
            {
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        roles 
                                        SET 
                                        role_name = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($role_name,$id));
                //Update Message
                if($upData){
                    //check if permission added
                    if(isset($_POST['permissions'])){
                        //delete previous role permissions
                        delete_role_permissions($id);
                        //add role permissions code
                        role_permissions($id,$_POST['permissions']);
                    }
                    $msg = show_msg('success','role Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('roles.php');
        }
    }
}
/*
function to delete role
*/
if(! function_exists('delete_role')){
    function delete_role(){
            global $con;
            $msg = '';
            //check if role ID from get request
            $role_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'roles', $role_id);
            // If There's Such ID Show The Form
            if ($check > 0) {
                //delete role permissions
                delete_role_permissions($role_id);
                //prepare to delete role
                $stmt = $con->prepare("DELETE FROM roles WHERE id = :zid");
                $stmt->bindParam(":zid", $role_id);
                $stmt->execute();
                
                $msg = show_msg('success','role Deleted Successfully');
            } else {
                $msg = show_msg('Error','This role is Not Found');
            }
            echo $msg;
            redirectPage('roles.php');
    }
}
/*
function to insert role permissions
get permissions & role ID
*/
if(!function_exists('role_permissions')){
    function role_permissions($role_id,$permissions){
        global $con;
        foreach($permissions as $permission){
            $stmt = $con->prepare("INSERT INTO roles_permissions (role_id,permssion_id) VALUES (:zrole_id,:zpermssion_id)");
            $stmt->execute(array(
                'zrole_id'   => $role_id,
                'zpermssion_id'       => $permission
            ));

        }
    }
}

/*
function to check role permission in edit form
take role_id , $permission_id
*/
if(!function_exists('check_role_permission')){
    function check_role_permission($role_id,$permission_id){
        global $con;
        $stmt = $con->prepare("SELECT * FROM roles_permissions WHERE role_id = ? AND permssion_id = ?");
        $stmt->execute(array($role_id,$permission_id));
        $count = $stmt->rowCount();
        return $count;
    }
}
/*
function to delete role permissions
take role_id
*/
if(! function_exists('delete_role_permissions')){
    function delete_role_permissions($role_id){
        global $con;
        $stmt = $con->prepare("DELETE FROM roles_permissions WHERE role_id = :zrole_id");
        $stmt->bindParam(":zrole_id", $role_id);
        $stmt->execute();
    }
}
