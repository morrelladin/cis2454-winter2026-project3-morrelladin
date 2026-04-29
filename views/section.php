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
                <th>Course Code</th>
                <th>Faculty ID</th>
                <th>Semester</th>
            </tr>
            <?php foreach ($sections as $section) : ?>
            <tr>
                <td><?php echo $section->get_id(); ?></td>
                <td><?php echo $section->get_course_code(); ?></td>
                <td><?php echo $section->get_faculty_id(); ?></td>
                <td><?php echo $section->get_semester(); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Add or Update Section</h2>
        <form action="section.php" method="post">
            <label>ID:</label>
            <input type="text" name="id"/><br>
            <label>Course Code:</label>
                <select name="course_code">
                    <?php foreach ($courses as $course) : ?>
                        <option value="<?php echo $course->get_code(); ?>">
                            <?php echo $course->get_name(); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
                <label>Faculty ID:</label>
                <select name="faculty_id">
                    <?php foreach ($faculties as $faculty) : ?>
                        <option value="<?php echo $faculty->get_id(); ?>">
                            <?php echo $faculty->get_id(); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
            
            <label>Semester:</label>
            <input type="text" name="semester"/><br>
            <input type="hidden" name="action" value="insert_or_update"/>
            <input type="radio" name="insert_or_update" value="insert" checked/>Add<br>
            <input type="radio" name="insert_or_update" value="update"/>Update<br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
        </form>
        
        <form action="sections.php" method="post">
            <select name="id">
                <?php foreach ($sections as $section) : ?>
                    <option value='<?php echo $section->get_id() ?>'><?php echo $section->get_course_code() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name='action' value='delete' />
            <label>&nbsp;</label>
            <input type="submit" value="Delete Section"/>
        </form>
    </body>
</html>