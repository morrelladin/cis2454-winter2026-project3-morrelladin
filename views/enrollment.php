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
                <th>Student ID</th>
                <th>Section ID</th>
                <th>Grade</th>
            </tr>
            <?php foreach ($enrollments as $enrollment) : ?>
            <tr>
                <td><?php echo $enrollment->get_id(); ?></td>
                <td><?php echo $enrollment->get_student_id(); ?></td>
                <td><?php echo $enrollment->get_section_id(); ?></td>
                <td><?php echo $enrollment->get_grade(); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add or Update Enrollment</h2>
        <form action="enrollment.php" method="post">
            <label>ID:</label>
            <input type="text" name="id"/><br>
            <label>Student:</label>
                <select name="student_id">
                    <?php foreach ($students as $student) : ?>
                        <option value="<?php echo $student->get_id(); ?>">
                            <?php echo $student->get_name(); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Section:</label>
                <select name="section_id">
                    <?php foreach ($sections as $section) : ?>
                        <option value="<?php echo $section->get_id(); ?>">
                            <?php echo $section->get_course_code(); ?> - <?php echo $section->get_semester(); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            <label>Grade:</label>
            <input type="text" name="grade"/><br>
            <input type="hidden" name="action" value="insert_or_update"/>
            <input type="radio" name="insert_or_update" value="insert" checked/>Add<br>
            <input type="radio" name="insert_or_update" value="update"/>Update<br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
        </form>
        
        <form action="enrollment.php" method="post">
            <select name="id">
                <?php foreach ($enrollments as $enrollment) : ?>
                    <option value='<?php echo $enrollment->get_id() ?>'><?php echo $enrollment->get_student_id() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name='action' value='delete' />
            <label>&nbsp;</label>
            <input type="submit" value="Delete Enrollment"/>
        </form>
    </body>
</html>