<?php
include 'Connection.php';


if (isset($_POST['search'])) {
    $search = htmlspecialchars(trim($_POST['search']));
    $sql = "SELECT * FROM mine WHERE ID LIKE ? OR fname LIKE ? OR lname LIKE ? OR email LIKE ? OR Mobile LIKE ? OR Title LIKE ? OR Exp LIKE ?";
    $stmt = $con->prepare($sql);
    $searchWildcard = "%$search%";
    $stmt->bind_param("sssssss", $searchWildcard, $searchWildcard, $searchWildcard, $searchWildcard, $searchWildcard, $searchWildcard, $searchWildcard);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $count = 1;

        while ($row = $result->fetch_assoc()) {
            $highlightedFname = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['fname']));
            $highlightedLname = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['lname']));
            $highlightedemail = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['email']));
            $highlightedMobile = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['Mobile']));
            $highlightedTitle = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['Title']));
            $highlightedExp = str_ireplace($search, "<span class='highlight'>$search</span>", htmlspecialchars($row['Exp']));
            echo '<tr>
                    <th scope="row">' . $count++ . '</th>
                    <td><a href="view.php?id=' . $row['ID'] . '" title="View"><i class="fas fa-eye"></i></a></td>
                    <td data-label="ACT">' . $highlightedFname . '</td>
                    <td data-label="Chapter">' . $highlightedLname . '</td>
                    <td data-label="Chapter Name">' . $highlightedemail . '</td>
                    <td data-label="Section">' . $highlightedMobile . '</td>
                    <td data-label="Title">' . $highlightedTitle . '</td>
                    <td data-label="Explanation">' . $highlightedExp . '</td>
                  </tr>';
                  
        }
    } else {
        echo '<tr>
                <td colspan="4" class="text-center text-danger">No results found.</td>
              </tr>';
    }
}
?>
