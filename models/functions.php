<?php 
    function checkPname($pname){
        $result = mysql_query("SELECT COUNT(*) FROM position WHERE Pname = '$pname'");
        return $result;
    }

    function updateDeductions($salary, $pid, $s, $p, $h, $pname){
        mysql_query("UPDATE deductions SET Amount = '$s' WHERE pid = '$pid' AND id = 1");
        mysql_query("UPDATE deductions SET Amount = '$h' WHERE pid = '$pid' AND id = 2");
        mysql_query("UPDATE deductions SET Amount = '$p' WHERE pid = '$pid' AND id = 3");
        mysql_query("UPDATE position SET Pname = '$pname', Salary = $salary WHERE pid = '$pid'");
    }

    function addPosition($pname){

        mysql_query("INSERT INTO position SET Pname = '$pname', Salary = 260");
        $result = mysql_query("SELECT pid FROM position WHERE Pname = '$pname' AND Salary = 260");
        $id = mysql_fetch_array($result);
        $id = $id['pid'];

        mysql_query("INSERT INTO deductions SET Amount = 0, pid = '$id', id = 1");
        mysql_query("INSERT INTO deductions SET Amount = 0, pid = '$id', id = 2");
        mysql_query("INSERT INTO deductions SET Amount = 0, pid = '$id', id = 3");
    }

    function getDeduct($pid, $did){
        $result = mysql_query("SELECT Amount FROM deductions WHERE pid = '$pid' and id = $did");
        return $result;
    }

	function getPosition($uname, $upass){
		$result = mysql_query("SELECT position, uid, username FROM users WHERE username = '$uname' and password = '$upass'");
		return $result;
	}

    function getPosition2($id){
        $result = mysql_query("SELECT Position FROM employees WHERE empID = '$id'");
        return $result;
    }

    function getEmployees(){
        $result = mysql_query("SELECT * FROM employees ORDER BY Lname");
        return $result;
    }

    function getEmp($search){
        $search = "%".$search."%";
        $result = mysql_query("SELECT * FROM employees, position WHERE employees.Position = position.pid AND 
        (empID LIKE '$search' OR Lname LIKE '$search' OR Mname LIKE '$search' OR Fname LIKE '$search'
        OR Fname LIKE '$search' OR Pname LIKE '$search') ORDER BY Lname");
        return $result;
    }

    function getName($id){
        $result = mysql_query("SELECT * FROM employees WHERE id ='$id'");
        return $result;
    }

    function getName2($id){
        $result = mysql_query("SELECT * FROM employees WHERE empID ='$id'");
        return $result;
    }

    function getEmployees2(){
        $result = mysql_query("SELECT * FROM employees WHERE Status = 'Active' ORDER BY Position");
        return $result;
    }

    function getEmployees3($p){
        $result = mysql_query("SELECT * FROM employees WHERE Position = '$p' AND Status = 'Active' ORDER BY Position");
        return $result;
    }

    function updateEmp($fn, $ln, $mn, $add, $p, $id){
        mysql_query("UPDATE employees SET Fname = '$fn'
                    , Lname = '$ln', Mname = '$mn', Address = '$add', Position = '$p' WHERE id='$id'");
    }

    function getPos($pos){
        $result = mysql_query("SELECT * FROM position WHERE pid = '$pos' LIMIT 1");
        return $result;
    }

    function disableEmp($id){
        mysql_query("UPDATE employees SET status = 'Inactive' WHERE id = '$id'");
    }

    function enableEmp($id){
        mysql_query("UPDATE employees SET status = 'Active' WHERE id = '$id'");
    }

    function getPosStart(){
        $result = mysql_query("SELECT * FROM position ORDER BY Pname LIMIT 1");
        return $result;
    }

    function saveEmp($fn, $ln, $mn, $add, $p, $empid){
        mysql_query("INSERT INTO employees SET empID = '$empid', Fname = '$fn', Lname = '$ln',
                     Mname = '$mn', Address = '$add', Position = '$p', status = 'Active'");
    }

    function getPname(){
        $result = mysql_query("SELECT pid, Pname FROM position ORDER BY Pname");
        return $result;
    }

    function getEmpInfo($id){
        $result = mysql_query("SELECT * FROM employees WHERE id = '$id'");
        return $result;
    }

    function createID($l, $m, $f){
        $empid = date('Y') . "-" . $l[0] . rand(0, 9). rand(0, 9). rand(0, 9). rand(0, 9) . $f[0] . $m[0];
        $result = getEmpInfo($empid);

        if (is_array($result))
            createID($l, $m, $f);
        else
            return $empid;
    }
    function checkPosition($pid){
        $result = mysql_query("SELECT COUNT(*) FROM employees WHERE Position = '$pid'");
        return $result;
    }

    function deletePosition($pid){
        mysql_query("DELETE FROM position WHERE pid = '$pid'");
        mysql_query("DELETE FROM deductions WHERE pid = '$pid'");
    }

    function getEmpID($e){
        $result = mysql_query("SELECT COUNT(*) FROM employees WHERE empID = '$e'");
        return $result;
    }

    function checkTime($e,$d,$m,$y){
        $result = mysql_query("SELECT COUNT(*) FROM dtr WHERE empID = '$e' AND JDay = '$d' AND jMonth = '$m' AND jYear = '$y' LIMIT 1");
        return $result;
    }

    function checkTime2($e,$d,$m,$y){
        $result = mysql_query("SELECT * FROM dtr WHERE empID = '$e' AND JDay = '$d' AND jMonth = '$m' AND jYear = '$y' LIMIT 1");
        return $result;
    }

    function saveDTR1($e,$d,$m,$y,$t){
        mysql_query("INSERT INTO dtr SET am_in = '$t', empID = '$e', am_out='0', 
            pm_in='0', pm_out='0' ,JDay = '$d', jMonth = '$m', jYear = '$y'");
    }

    function saveDTR2($t,$dtrID){
        mysql_query("UPDATE dtr SET am_out = '$t' WHERE id = '$dtrID'");
    }

    function saveDTR3($t,$dtrID){
        mysql_query("UPDATE dtr SET pm_in = '$t' WHERE id = '$dtrID'");
    }

    function saveDTR4($t,$dtrID){
        mysql_query("UPDATE dtr SET pm_out = '$t' WHERE id = '$dtrID'");
    }

    function saveDTR5($e,$d,$m,$y,$t){
        mysql_query("INSERT INTO dtr SET am_in = '0', empID = '$e', am_out='0', 
            pm_in='$t', pm_out='0' ,JDay = '$d', jMonth = '$m', jYear = '$y'");
    }

    function getDTR($id, $year, $month){
        $result = mysql_query("SELECT * FROM dtr WHERE empid = '$id' AND jYear = '$year' AND jMonth = '$month'");
        return $result;
    }

    function getDTR2($id, $year, $month, $c){
        $result = mysql_query("SELECT * FROM dtr WHERE empid = '$id' AND jYear = '$year' AND jMonth = '$month' AND jDay = '$c'");
        return $result;
    }

    function getDeduction($pid){
        $result = mysql_query("SELECT * FROM deductions WHERE pid = '$pid'");
        return $result;
    }

    function getUname($id){
        $result = mysql_query("SELECT * FROM users WHERE empID = '$id'");
        return $result;
    }

    function getPass($op){
        $id = $_SESSION['user_id'];
        $result = mysql_query("SELECT COUNT(*) FROM users WHERE empID = '$id' AND password = '$op'");
        return $result;
    }

    function updatePass($np){
        $id = $_SESSION['user_id'];
        $result = mysql_query("UPDATE users SET password = '$np' WHERE empID = '$id'");
        return $result;
    }

    function updateUname($user){
        $id = $_SESSION['user_id'];
        $result = mysql_query("UPDATE users SET username = '$user' WHERE empID = '$id'");
        return $result;
    }

    function getManagers(){
        $result = mysql_query("SELECT * FROM employees, position WHERE employees.Position = position.pid
         and Pname = 'Manager' AND employees.status = 'Active'");
        return $result;
    }

    function getSupervisors(){
        $result = mysql_query("SELECT * FROM employees, position WHERE employees.Position = position.pid
         and Pname = 'Supervisor' AND employees.status = 'Active'");
        return $result;
    }

    function getManagers2(){
        $result = mysql_query("SELECT * FROM employees, users, position WHERE employees.id = users.empID 
            AND employees.Position = position.pid AND Pname = 'Manager' AND employees.status = 'Active'");
        return $result;
    }

    function getSupervisors2(){
        $result = mysql_query("SELECT * FROM employees, users, position WHERE employees.id = users.empID 
            AND employees.Position = position.pid  AND Pname = 'Supervisor' AND employees.status = 'Active'");
        return $result;
    }

    function checkID($id){
        $result = mysql_query("SELECT COUNT(*) FROM users WHERE empID = '$id'");
        return $result;
    }

    function saveUser($uid, $uname, $pass){
        mysql_query("INSERT INTO users SET empID = '$uid', username = '$uname', password = '$pass'");
    }

    function checkStat($id){
        $result = mysql_query("SELECT * FROM employees, position WHERE employees.id = '$id' AND position.pid = employees.Position");
        return $result;
    }
 ?>