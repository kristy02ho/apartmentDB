<!DOCTYPE html>
<html>

<head>
    <title>Welcome to your Database Page</title>
    <style>
        body {
            background-color: #CFB87C;
            text-align: center;
            font-family: "Arial";
            font-weight: bold;
            text-transform: uppercase;
        }

        h1 {
            font-family: "Arial";
        }

        table {
            width: 100%;
            margin: 0 auto;
        }

        caption {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    $link = mysqli_connect("localhost", "hokr", "bXPDpLaNvJdU", "hokr_DB");
    // VIEW 1
    $sql = "SELECT APARTMENT.ApartmentNo, TENANT.FName, TENANT.LName, TENANT.PhoneNumber, TENANT.Email FROM TENANT JOIN LEASE ON TENANT.LeaseID=LEASE.LeaseID JOIN APARTMENT ON ApartmentID=ApartmentNo";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-dark' style='width:50%; margin: 0 auto;'>";
            echo "<caption><h2>Apartment Numbers & Tenant Contact Info</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align: left;'>";
            echo "<th> Apartment Number </th>";
            echo "<th> First Name </th>";
            echo "<th> Last Name </th>";
            echo "<th> Phone Number </th>";
            echo "<th> Email </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['ApartmentNo'] . "</td>";
                echo "<td>" . $row['FName'] . "</td>";
                echo "<td>" . $row['LName'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records matching your query were found. ";
        }
    } else {
        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    // VIEW 2
    $sql = "SELECT LEASE.LeaseID, LEASE.Term, TENANT.FName, TENANT.LName, TENANT.PhoneNumber, TENANT.Email, PAYMENT.DueDate, PAYMENT.PaidDate, PAYMENT.Amount FROM TENANT NATURAL JOIN LEASE NATURAL JOIN PAYMENT WHERE PAYMENT.DueDate < PAYMENT.PaidDate";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-dark' style='width:75%; margin: 0 auto;'>";
            echo "<caption><h2>Late Payments & Tenant Contact Info</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align: left'>";
            echo "<th> Lease ID </th>";
            echo "<th> Term (Months) </th>";
            echo "<th> First Name </th>";
            echo "<th> Last Name </th>";
            echo "<th> Phone Number </th>";
            echo "<th> Email </th>";
            echo "<th> Due Date </th>";
            echo "<th> Paid Date </th>";
            echo "<th> Payment Amount </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['LeaseID'] . "</td>";
                echo "<td>" . $row['Term'] . "</td>";
                echo "<td>" . $row['FName'] . "</td>";
                echo "<td>" . $row['LName'] . "</td>";
                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";

                echo "<td>" . $row['DueDate'] . "</td>";
                echo "<td>" . $row['PaidDate'] . "</td>";
                echo "<td>" . $row['Amount'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records matching your query were found. ";
        }
    } else {
        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    // VIEW 3
    $sql = "SELECT DISTINCT LEASE.LeaseID, TENANT.FName, TENANT.LName, TENANT.PhoneNumber, LEASE.StartDate, LEASE.ExpirationDate, AMENITIES.AmenityName
FROM LEASE
JOIN TENANT ON LEASE.LeaseID = TENANT.LeaseID
JOIN AMENITY_USED ON TENANT.TenantID = AMENITY_USED.TenantID
JOIN AMENITIES ON AMENITY_USED.AmenityID = AMENITIES.AmenityID WHERE LEASE.ExpirationDate >= CURDATE() AND LEASE.ExpirationDate <= DATE_ADD(CURDATE(), INTERVAL 90 DAY) AND AMENITIES.FlagType = 'RENTAL'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-dark' style='width:75%; margin: 0
auto;'>";
            echo "<caption><h2>Leases Expiring in 3
Months</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align: left'>";
            echo "<th> Lease ID </th>";
            echo "<th> First Name </th>";
            echo "<th> Last Name </th>";
            echo "<th> Phone Number </th>";
            echo "<th> Lease Start Date </th>";
            echo "<th> Lease Expiration Date</th>";
            echo "<th> Amenity Name </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['LeaseID'] . "</td>";
                echo "<td>" . $row['FName'] . "</td>";
                echo "<td>" . $row['LName'] . "</td>";

                echo "<td>" . $row['PhoneNumber'] . "</td>";
                echo "<td>" . $row['StartDate'] . "</td>";
                echo "<td>" . $row['ExpirationDate'] . "</td>";
                echo "<td>" . $row['AmenityName'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records matching your query were found. ";
        }
    } else {
        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    // VIEW 4
    $sql = "SELECT
AMENITIES.FlagType, YEAR(AMENITY_USED.StartDate) AS StartYear, MONTH(AMENITY_USED.StartDate) AS StartMonth, SUM(AMENITIES.Price * COALESCE((AMENITY_USED.ReturnDate -
AMENITY_USED.StartDate), 1)) AS TotalAmount FROM
    AMENITIES
JOIN
AMENITY_USED ON AMENITIES.AmenityID = AMENITY_USED.AmenityID WHERE
AMENITY_USED.StartDate >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 365 DAY), '%Y-%m-01')
AND (AMENITIES.FlagType = 'LOAN' OR AMENITIES.FlagType = 'SALE') GROUP BY
AMENITIES.FlagType, StartMonth, StartYear ORDER BY
StartYear, StartMonth, AMENITIES.FlagType;";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-dark' style='width:50%; margin: 0
auto;'>";
            echo "<caption><h2>Total Sales & Loans Profit By Month
</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align: left'>";
            echo "<th> Type </th>";
            echo "<th> Year </th>";
            echo "<th> Month </th>";
            echo "<th> Profit </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['FlagType'] . "</td>";
                echo "<td>" . $row['StartYear'] . "</td>";
                echo "<td>" . $row['StartMonth'] . "</td>";
                echo "<td>" . $row['TotalAmount'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records matching your query were found. ";
        }
    } else {
        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    // VIEW 5
    $sql = "SELECT MAINTENANCE_JOB.Category, MAINTENANCE_JOB.DateRequested, MAINTENANCE_JOB.DateScheduled, MAINTENANCE_JOB.DateCompleted FROM MAINTENANCE_JOB ORDER BY MAINTENANCE_JOB.Category, MAINTENANCE_JOB.DateRequested;";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table-dark' style='width:50%; margin: 0
auto;'>";
            echo "<caption><h2>Maintenance Projects</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align:left;'>";
            echo "<th> Category</th>";
            echo "<th> Date Requested </th>";
            echo "<th> Date Scheduled</th>";
            echo "<th> Date Completed</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['Category'] . "</td>";
                echo "<td>" . $row['DateRequested'] . "</td>";
                echo "<td>" . $row['DateScheduled'] . "</td>";
                echo "<td>" . $row['DateCompleted'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {

            echo "No records matching your query were found. ";
        }
    } else {
        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    // VIEW 6
    $sql = "SELECT MAINTENANCE_JOB.Category, MAINTENANCE_JOB.Quarter, COUNT(MAINTENANCE_JOB.DateCompleted) AS
CompletedProjects, (COUNT(MAINTENANCE_JOB.DateCompleted) /
COUNT(MAINTENANCE_JOB.DateRequested) * 100) AS PercentageComplete, AVG(MAINTENANCE_JOB.CompletionTime) AS AverageTime
FROM MAINTENANCE_JOB
GROUP BY MAINTENANCE_JOB.Category, MAINTENANCE_JOB.Quarter;";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='center table-dark' style='width:75%; margin: 0 auto;'>";
            echo "<caption><h2>Quarterly Report of Maintenance Projects</h2></caption>";
            echo "<thead>";
            echo "<tr style='text-align:left;'>";
            echo "<th> Category</th>";
            echo "<th> Quarter </th>";
            echo "<th> Number of Completed Projects</th>";
            echo "<th> Percentage of Completed Projects</th>";
            echo "<th> Average Completion Time (Hours)</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['Category'] . "</td>";
                echo "<td>" . $row['Quarter'] . "</td>";
                echo "<td>" . $row['CompletedProjects'] . "</td>";
                echo "<td>" . number_format($row['PercentageComplete'], 2) . "%</td>";
                echo "<td>" . $row['AverageTime'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No records matching your query were found. ";
        }
    } else {

        echo "ERROR: was not able to execute SQL query. " .
            mysqli_error($link);
    }
    ?>
</body>

</html>