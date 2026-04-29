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
                <th>Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Credits</th>
            </tr>
            <?php foreach ($courses as $course) : ?>
            <tr>
                <td><?php echo $course->get_code(); ?></td>
                <td><?php echo $course->get_name(); ?></td>
                <td><?php echo $course->get_description(); ?></td>
                <td><?php echo $course->get_credits(); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add or Update Course</h2>
        <form action="course.php" method="post">
            <label>Code:</label>
            <input type="text" name="code"/><br>
            <label>Name:</label>
            <input type="text" name="name"/><br>
            <label>Description:</label>
            <input type="text" name="description"/><br>
            <label>Credits:</label>
            <input type="text" name="credits"/><br>
            <input type="hidden" name="action" value="insert_or_update"/>
            <input type="radio" name="insert_or_update" value="insert" checked/>Add<br>
            <input type="radio" name="insert_or_update" value="update"/>Update<br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
        </form>
        
        <form action="course.php" method="post">
            <select name="code">
                <?php foreach ($courses as $course) : ?>
                    <option value='<?php echo $course->get_code() ?>'><?php echo $course->get_name() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name='action' value='delete' />
            <label>&nbsp;</label>
            <input type="submit" value="Delete Course"/>
        </form>
    </body>
</html>