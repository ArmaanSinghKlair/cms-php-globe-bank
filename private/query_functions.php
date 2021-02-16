<?php
    function find_all_subjects($options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM subjects";
        if($visible)
            $sql .= " where visible = ".mysqli_real_escape_string($db,$visible);
        $sql .= " ORDER BY position ";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_all_pages(){
        global $db;
        $sql = "SELECT * FROM pages";
        $sql .= " ORDER BY subject_id ASC,position ASC";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }
   
    function find_all_admins(){
        global $db;
        $sql = "SELECT * FROM admins";
        $result_set = mysqli_query($db,$sql);
        if(mysqli_errno($db)){
            echo mysqli_error($db);
            exit;
        }else{
            return $result_set;
        }
        
    }

    function find_admin_by_id($id){
        global $db;
        $sql = "SELECT * FROM admins";
        $sql .= " where id = ? LIMIT 1";
        $stmt = mysqli_prepare($db,$sql);
        mysqli_stmt_bind_param($stmt, 'i',$id);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_errno($stmt)){
            echo mysqli_stmt_error($stmt);
        }else{
            $admin = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $admin;
        }

    }

    function find_admin_by_username($username){
        global $db;
        $sql = "SELECT * FROM admins";
        $sql .= " where username = ? LIMIT 1";
        $stmt = mysqli_prepare($db,$sql);
        mysqli_stmt_bind_param($stmt, 'i',$username);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_errno($stmt)){
            echo mysqli_stmt_error($stmt);
        }else{
            $admin = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $admin;
        }

    }

    function find_subject_by_id($id,$options=[]){
        global $db;
        $visible=$options['visible']?? false;
        $sql = "SELECT * FROM subjects";
        $sql .= " WHERE id = '".db_escape($id)."'";
        if($visible)
            $sql .=" and visible = true";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $subject = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $subject;
    }
    
    function find_page_by_id($id,$options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages";
        $sql .= " WHERE id = '".db_escape($id)."'";
        if($visible==true)
            $sql .=" and visible = true";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page;
    }

    function find_pages_by_subject_id($id,$options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT * FROM pages";
        $sql .= " WHERE subject_id = '".db_escape($id)."'";
        if($visible==true)
            $sql .=" and visible = true";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        return $result;
    }

    function find_page_count_by_subject_id($id,$options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $sql = "SELECT COUNT(id)  FROM pages";
        $sql .= " WHERE subject_id = '".db_escape($id)."'";
        if($visible==true)
            $sql .=" and visible = true";

        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $count = mysqli_fetch_row($result)[0];
        mysqli_free_result($result);
        return $count;
    }

    function insert_admin($admin){
        global $db;
        $errors = validate_admin($admin);
        if(!empty($errors))
            return $errors;
        $hashed_password = password_hash($admin['password'],PASSWORD_BCRYPT);    
        $sql = "INSERT INTO admins(first_name,last_name,email,username,hashed_password)";
        $sql .= "VALUES(?,?,?,?,?);";
        $stmt = mysqli_prepare($db,$sql);
        mysqli_stmt_bind_param($stmt,'sssss',$admin['first_name'],$admin['last_name'],$admin['email'],$admin['username'],$hashed_password);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_errno($stmt)){
            echo mysqli_stmt_error($stmt);
            exit;
        }else{
            if(mysqli_stmt_affected_rows($stmt) > 0)
                return true;
            else
                return false;
        }
    }
    function create_new_subject($subject){
        global $db;
        $errors = validate_subject($subject);
        if(!empty($errors))
            return $errors;
        $sql = "INSERT INTO subjects";
        $sql .=" (menu_name,position, visible)";
        $sql .= " VALUES (";
        $sql .= "'".db_escape($subject['menu_name'])."',";
        $sql .= "'".db_escape($subject['position'])."',";
        $sql .= "'".db_escape($subject['visible'])."')";
        $result = mysqli_query($db, $sql);

        if($result){
           return true; 
        }
        else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function create_new_page($page){
        global $db;
        $errors = validate_page($page);
        if(!empty($errors))
            return $errors;
            
        $sql = "INSERT INTO pages";
        $sql .=" (subject_id,menu_name,position, visible,content)";
        $sql .= " VALUES (";
        $sql .= "'".db_escape($page['subject_id'])."',";
        $sql .= "'".db_escape($page['menu_name'])."',";
        $sql .= "'".db_escape($page['position'])."',";
        $sql .= "'".db_escape($page['visible'])."',";
        $sql .= "'".db_escape($page['content'])."')";

        $result = mysqli_query($db, $sql);

        if($result){
           return true; 
        }
        else {
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function update_subject($subject,$id){
        global $db;  

        $errors = validate_subject($subject);
        if(!empty($errors))
            return $errors;
        $sql = "UPDATE subjects SET";
        $sql .= " menu_name=";
        $sql .= "'".db_escape($subject['menu_name'])."',";
        $sql .= " position=";
        $sql .= "'".db_escape($subject['position'])."',";
        $sql .= " visible=";
        $sql .= "'".db_escape($subject['visible'])."'";
        $sql .=" WHERE id='".$id."' LIMIT 1;";
        $sql .= "";
        
        $result = mysqli_query($db, $sql);
        if($result){
            return true;
        }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
        }
       
       
    }

    function update_admin($admin){
        global $db;
        $password_sent = !is_blank($admin['password']);
        $errors = validate_admin($admin,['password_required'=>$password_sent]);
        if(!empty($errors))
            return $errors;
        $hashed_password = password_hash($admin['password'],PASSWORD_BCRYPT);    
        $sql = "UPDATE admins set";
        $sql .=" first_name = ?,last_name=?,email = ?, username=?";
        if($password_sent)
            $sql .=",hashed_password=?";
        $sql .= " where id = ?";
        $stmt = mysqli_prepare($db,$sql);
        if($password_sent)
            mysqli_stmt_bind_param($stmt,'sssssi',$admin['first_name'],$admin['last_name'],$admin['email'],$admin['username'],$hashed_password,$admin['id']);
        else
            mysqli_stmt_bind_param($stmt,'ssssi',$admin['first_name'],$admin['last_name'],$admin['email'],$admin['username'],$admin['id']);

        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_errno($stmt)){
            echo mysqli_stmt_error($stmt);
            exit;
        }
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return true;
        
    }

    function update_page($page){
        global $db;
        $errors = validate_page($page);
        if(!empty($errors))
            return $errors;

        $sql = "UPDATE pages SET";
        $sql .= " menu_name = '".db_escape($page['menu_name'])."',";
        $sql .= " position = '".db_escape($page['position'])."',";
        $sql .= " visible = '".db_escape($page['visible'])."',";
        $sql .= " content = '".db_escape($page['content'])."',";
        $sql .= " subject_id = '".db_escape($page['subject_id'])."'";
        $sql .= " where id = '".db_escape($page['id'])."'";
        $result = mysqli_query($db, $sql);
        if($result){
            return true;
            db_disconnect($db);
        } else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function get_subject_count(){
        global $db;
        $subject_count=0;
        $sql = "SELECT COUNT(*) AS 'subject_count' FROM SUBJECTS";
        $result = mysqli_query($db,$sql);
        if($result){
        $subject_count = mysqli_fetch_assoc($result)['subject_count'];
        mysqli_free_result($result);
        }
        else{
        echo mysqli_error($db);
        exit;
        }
        return $subject_count;

    }

    function get_page_count(){
        global $db;
        $page_count=0;
        $sql = "SELECT COUNT(*) AS 'page_count' FROM pages";
        $result = mysqli_query($db,$sql);
        if($result){
        $page_count = mysqli_fetch_assoc($result)['page_count'];
        mysqli_free_result($result);
        }
        else{
        echo mysqli_error($db);
        exit;
        }
        return $page_count;

    }

    function delete_subject($id){
        global $db;
        $sql = "DELETE FROM subjects WHERE";
        $sql .= " id = '".db_escape($id)."' LIMIT 1;";
        
        if(mysqli_query($db,$sql)){
            return true;
        } else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_page($id){
        global $db;
        $sql = "DELETE FROM pages WHERE";
        $sql .= " id = '".db_escape($id)."' LIMIT 1;";
        
        if(mysqli_query($db,$sql)){
            return true;
        } else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }

    function delete_admin($id){
        global $db;
        $sql = "DELETE FROM admins";
        $sql .=" where id = ?";
        $stmt = mysqli_prepare($db,$sql);
        mysqli_stmt_bind_param($stmt,'i',$id);
        mysqli_stmt_execute($stmt);
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affected_rows>0;
    }

    function validate_page($page){
        $errors = [];
         if(is_blank($page['menu_name']))
            $errors[] = "Name cannot be blank.";
        if(!has_length($page['menu_name'],['min'=>2, 'max'=>255]))
            $errors[] = "Name must be between 2 and 255 characters long";
        
        if(!in_array($page['visible'],[0,1]))
            $errors[] = "Visible be must be true or false";
        if($page['position'] <= 0)
            $errors[] = "Position must be more than 0";
        if($page['position'] > 999)
            $errors[] = "Position must be less than 999";
        return $errors;
    }

    function get_pages_by_subject($subject_id,$options=[]){
        global $db;
        $visible = $options['visible'] ?? false;
        $visibleIntVal = $visible?1:0;
        $sql = "SELECT * FROM pages WHERE";
        $sql .= " subject_id = ?";
        if($visible)
            $sql.= " and visible=?";
        $sql .= " order by position asc";
        $ps = mysqli_prepare($db, $sql);
        if($visible)
            mysqli_stmt_bind_param($ps,'ii',$subject_id,$visibleIntVal);
        else
            mysqli_stmt_bind_param($ps, 'i',$subject_id);
        mysqli_stmt_execute($ps);

        return array(mysqli_stmt_get_result($ps),$ps);
        
    }

    function validate_admin($admin,$options = []){
        $errors = array();
        if(!has_length($admin['first_name'],['min'=>2,'max'=>255])){
            $errors[] = "First name can be at least 2 characters and at most 255 characters";
        } 
        if(!has_length($admin['last_name'],['min'=>2,'max'=>255])){
            $errors[] = "Last name can be at least 2 characters and at most 255 characters";
        } 
        if(is_blank($admin['email'])){
            $errors[] = "Email cannot be blank";
        }
        if(!has_length($admin['email'],['min'=>1,'max'=>255])){
            $errors[] = "Email can be at max 255 characters";
        }
        if(!has_valid_email_format($admin['email'])){
            $errors[] = "Email has invalid address";
        }
        if(!has_length($admin['username'],['min'=>8,'max'=>255])){
            $errors[] = "Username can be at least 8 characters and at most 255 characters";
        }
        if($options['password_required']){
            if(!has_length($admin['password'],['min'=>12])){
                $errors[] = "Password should have 12+ characters";
            }
            if(strcmp($admin['password'],$admin['confirm_password']) !== 0){
                $errors[] = "Password and confirm password do not match";
            } else if(!preg_match("/[A-Z]+/",$admin['password'])){
                $errors[] = "Password must contain at least one uppercase letter";
            }else if(!preg_match("/[a-z]+/",$admin['password'])){
                $errors[] = "Password must contain at least one lowercase letter";
            }else if(!preg_match("/[0-9]+/",$admin['password'])){
                $errors[] = "Password must contain at least one number";
            }
    }
        return $errors;
    }
    function validate_subject($subject) {


        $errors = [];
        
        // menu_name
        if(is_blank($subject['menu_name'])) {
          $errors[] = "Name cannot be blank.";
        }
        if(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
          $errors[] = "Name must be between 2 and 255 characters.";
        }
      
        // position
        // Make sure we are working with an integer
        $postion_int = (int) $subject['position'];
        if($postion_int <= 0) {
          $errors[] = "Position must be greater than zero.";
        }
        if($postion_int > 999) {
          $errors[] = "Position must be less than 999.";
        }
      
        // visible
        // Make sure we are working with a string
        $visible_str = (string) $subject['visible'];
        if(!has_inclusion_of($visible_str, ["0","1"])) {
          $errors[] = "Visible must be true or false.";
        }
      
        return $errors;
      }     
?>