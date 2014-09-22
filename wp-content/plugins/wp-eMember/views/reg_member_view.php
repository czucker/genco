<form action="" method="post" name="regoForm" id="regoForm" >
    <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">

        <tr>
            <td>Title: </td>
            <td><select name="atitle">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>First Name*: </td>
            <td><input type="text" name="afirstname" size=20 value="<?= $_POST['afirstname'] ?>" class="required"></td>
        </tr>
        <tr>
            <td>Last Name*: </td>
            <td><input type="text" name="alastname" size=20 value="<?= $_POST['alastname'] ?>" class="required"></td>
        </tr>
        <tr>
            <td>Email*: </td>
            <td><input type="text" name="aemail" size=20 value="<?= $_POST['aemail'] ?>" class="required"></td>
        </tr>
        <tr>
            <td>User Name*: </td>
            <td><input type="text" name="user_name" size=20 value="<?= $_POST['user_name'] ?>" class="required"></td>
        </tr>
        <tr>
            <td>Password*: </td>
            <td><input type="password" name="pwd" size=20 value="<?= $_POST['pwd'] ?>" class="required"></td>
        </tr>
    </table>
    <input name="doRegister" type="submit" id="doRegister" class="button" value="Register">
</form>