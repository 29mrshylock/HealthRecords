<?php
// Database connection details
include '../includes/config.php';



if (isset($_GET['doctor_id'])) {
    $doctor_id = mysqli_real_escape_string($conn, $_GET['doctor_id']);

    $sql = "SELECT * FROM appointments WHERE doctor_id = '$doctor_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Patient List</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Patient Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Symptoms</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row['name']."</td>
                        <td>".$row['phone']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['date']."</td>
                        <td>".$row['time']."</td>
                        <td>".$row['symptoms']."</td>
                        <td>".$row['status']."</td>
                        <td>
                            <form method='post'>
                                <input type='hidden' name='appointment_id' value='".$row['id']."'>
                                <input type='hidden' name='doctor_id' value='".$doctor_id."'>
                                <input type='submit' name='accept' value='Accept'>
                                <input type='submit' name='pending' value='Pending'>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No patients found.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Status update
    if (isset($_POST['accept'])) {
        $appointment_id = $_POST['appointment_id'];
        $update_sql = "UPDATE appointments SET status = 'confirmed' WHERE id = '$appointment_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Appointment confirmed!";
            // After update, reload the page with doctor_id in URL
            header("Location: ".$_SERVER['PHP_SELF']."?doctor_id=".$_POST['doctor_id']);
            exit();
        } else {
            echo "Error updating appointment: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['pending'])) {
        $appointment_id = $_POST['appointment_id'];
        $update_sql = "UPDATE appointments SET status = 'pending' WHERE id = '$appointment_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo "Appointment marked as pending!";
            // After update, reload the page with doctor_id in URL
            header("Location: ".$_SERVER['PHP_SELF']."?doctor_id=".$_POST['doctor_id']);
            exit();
        } else {
            echo "Error updating appointment: " . mysqli_error($conn);
        }
    }

} else {
    echo "No doctor specified.";
}

mysqli_close($conn);
?>


<!-- using api -->

<?php
// $servername = "localhost";
// $username = "root";
// $dbpassword = "";
// $dbName = "hospital";

// // Connect to the database
// $con = mysqli_connect($servername, $username, $dbpassword, $dbName);

// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// // Check if doctor is passed via URL query
// if (isset($_GET['doctor'])) {
//     // Sanitize the doctor name
//     $doctor = mysqli_real_escape_string($con, $_GET['doctor']);

//     // SQL query to fetch patient details for the specified doctor
//     $sql = "SELECT * FROM appointments WHERE doctor = '$doctor'";

//     $result = mysqli_query($con, $sql);

//     if ($result) {
//         if (mysqli_num_rows($result) > 0) {
//             echo "<h2>Patient List for Dr. $doctor</h2>";
//             echo "<table border='1'>
//                     <tr>
//                         <th>Patient Name</th>
//                         <th>Phone</th>
//                         <th>Email</th>
//                         <th>Appointment Date</th>
//                         <th>Appointment Time</th>
//                         <th>Symptoms</th>
//                         <th>Status</th>
//                         <th>Action</th>
//                     </tr>";

//             // Loop through and display the patient data
//             while ($row = mysqli_fetch_assoc($result)) {
//                 echo "<tr>
//                         <td>".$row['name']."</td>
//                         <td>".$row['phone']."</td>
//                         <td>".$row['email']."</td>
//                         <td>".$row['date']."</td>
//                         <td>".$row['time']."</td>
//                         <td>".$row['symptoms']."</td>
//                         <td>".$row['status']."</td>
//                         <td>
//                             <form method='post'>
//                                 <input type='hidden' name='appointment_id' value='".$row['id']."'>
//                                 <input type='submit' name='accept' value='Accept'>
//                                 <input type='submit' name='pending' value='Pending'>
//                             </form>
//                         </td>
//                     </tr>";
//             }
//             echo "</table>";
//         } else {
//             echo "No patients found for Dr. $doctor.";
//         }
//     } else {
//         echo "Error: " . mysqli_error($con);
//     }

//     // Handle status update (Accept or Pending)
//     if (isset($_POST['accept'])) {
//         $appointment_id = $_POST['appointment_id'];
//         $update_sql = "UPDATE appointments SET status = 'confirmed' WHERE id = '$appointment_id'";

//         if (mysqli_query($con, $update_sql)) {
//             echo "Appointment confirmed!";

//             // Fetch patient details for email notification
//             $patient_sql = "SELECT * FROM appointments WHERE id = '$appointment_id'";
//             $patient_result = mysqli_query($con, $patient_sql);
//             $patient = mysqli_fetch_assoc($patient_result);

//             // Send confirmation email to the patient
//             $to = $patient['email'];
//             $subject = "Appointment Confirmation with Dr. $doctor";
//             $message = "Dear " . $patient['name'] . ",\n\nYour appointment with Dr. $doctor has been confirmed for " . $patient['date'] . " at " . $patient['time'] . ".\n\nThank you for using our services.";
//             $headers = "From: no-reply@hospital.com";

//             // Send the email
//             if (mail($to, $subject, $message, $headers)) {
//                 echo "Confirmation email sent to the patient.";
//             } else {
//                 echo "Error sending email.";
//             }

//         } else {
//             echo "Error updating appointment: " . mysqli_error($con);
//         }
//     }

//     if (isset($_POST['pending'])) {
//         $appointment_id = $_POST['appointment_id'];
//         $update_sql = "UPDATE appointments SET status = 'pending' WHERE id = '$appointment_id'";
//         if (mysqli_query($con, $update_sql)) {
//             echo "Appointment marked as pending!";
//         } else {
//             echo "Error updating appointment: " . mysqli_error($con);
//         }
//     }

// } else {
//     echo "No doctor specified.";
// }

// mysqli_close($con);
?>