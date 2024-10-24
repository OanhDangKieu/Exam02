<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">PHP Example</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="connect.php">Connect MySQL</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-3">
        <nav class="alert alert-primary" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Index</li>
            </ol>
        </nav>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
        <?php
        session_start();
        require_once 'database.php';
        if (isset($_SESSION['db_connection'])) {
            $db_info = $_SESSION['db_connection'];

            $db = new Database($db_info['server'], $db_info['username'], $db_info['password']);
            $conn = $db->connect();

            if ($conn) {
                $stmt = $conn->prepare("SELECT * FROM course");
                $stmt->execute();
                $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            if (!empty($courses)) {
                foreach ($courses as $course) {
                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($course['ImageUrl']) . "' alt='" . htmlspecialchars($course['Title']) . "' style='width: 100px;'></td>";
                    echo "<td>" . htmlspecialchars($course['Title']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['Description']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
            } else {
                echo "<tr><td colspan='3'>Không có khóa học nào.</td></tr>";
            }
            } else {
                echo "Không thể kết nối tới cơ sở dữ liệu!";
                die();
            }
        } else {
            echo "Chưa có thông tin kết nối, vui lòng kết nối trước.";
            die(); 
        }
        ?>
        </tbody>
        </table>
        <hr>
        <form class="row" method="POST" enctype="multipart/form-data">
            <div class="col">
                <div class="form-floating mb-3">
                    <input value="data" type="text" class="form-control" id="server" placeholder="File name" name="filename">
                    <label for="data">File name</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Write file</button>
            </div>
            <div class="col">
            </div>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $filename = $_POST['filename'];
            $file_path = "C:/xampp/htdocs/example/example/" . $filename;
            $data_to_write = "This is the content of the file."; 
            file_put_contents($file_path, $data_to_write);
            echo "<div class='alert alert-success'>File '{$filename}' đã được ghi.</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>