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
                <th>Email</th>
            </tr>
            <?php foreach ($faculties as $faculty) : ?>
            <tr>
                <td><?php echo $faculty->get_id(); ?></td>
                <td><?php echo $faculty->get_name(); ?></td>
                <td><?php echo $faculty->get_email(); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add or Update Faculty</h2>
        <form action="faculty.php" method="post">
            <label>ID:</label>
            <input type="text" name="id"/><br>
            <label>Name:</label>
            <input type="text" name="name"/><br>
            <label>Email:</label>
            <input type="text" name="email"/><br>
            <input type="hidden" name="action" value="insert_or_update"/>
            <input type="radio" name="insert_or_update" value="insert" checked/>Add<br>
            <input type="radio" name="insert_or_update" value="update"/>Update<br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
        </form>
        
        <form action="faculty.php" method="post">
            <select name="id">
                <?php foreach ($faculties as $faculty) : ?>
                    <option value='<?php echo $faculty->get_id() ?>'><?php echo $faculty->get_name() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name='action' value='delete' />
            <label>&nbsp;</label>
            <input type="submit" value="Delete Faculty"/>
        </form>
    </body>
</html>