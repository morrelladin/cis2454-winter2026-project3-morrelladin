<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php include ('views/nav.php'); ?>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Major</th>
            </tr>
            <?php foreach ($students as $student) : ?>
            <tr>
                <td><?php echo $student->get_id(); ?></td>
                <td><?php echo $student->get_name(); ?></td>
                <td><?php echo $student->get_major(); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add or Update Student</h2>
        <form action="students.php" method="post">
            <label>ID:</label>
            <input type="text" name="id"/><br>
            <label>Name:</label>
            <input type="text" name="name"/><br>
            <label>Major:</label>
            <input type="text" name="major"/><br>
            <input type="hidden" name="action" value="insert_or_update"/>
            <input type="radio" name="insert_or_update" value="insert" checked/>Add<br>
            <input type="radio" name="insert_or_update" value="update"/>Update<br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
        </form>
        
        <form action="students.php" method="post">
            <select name="id">
                <?php foreach ($students as $student) : ?>
                    <option value='<?php echo $student->get_id() ?>'><?php echo $student->get_name() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name='action' value='delete' />
            <label>&nbsp;</label>
            <input type="submit" value="Delete Student"/>
        </form>
    </body>
</html>