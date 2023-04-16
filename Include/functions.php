<?php
// include "./config.php";

/**
 * Get the first 10 courses.
 *
 * @return array|bool Returns an array of courses on success, or false on failure.
 */
function get_courses($limit)
{
    global $conn;

    $sql = "SELECT * FROM course WHERE status = 'approved' LIMIT $limit";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }

    $courses = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }

    return $courses;
}


function get_course($course_id)
{
    global $conn;

    $stmt = $conn->prepare('SELECT * FROM course WHERE course_id = ?');
    $stmt->bind_param('i', $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function get_student_courses($student_id)
{
    global $conn;

    $stmt = $conn->prepare("SELECT course_id FROM enroll_students WHERE student_id = ?");
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $courses = array(); // Initialize an array to hold the course information

    while ($row = $result->fetch_assoc()) {
        $course_id = $row['course_id'];
        $course = get_course($course_id); // Get the course information
        array_push($courses, $course); // Add the course information to the array
    }

    return $courses;
}
