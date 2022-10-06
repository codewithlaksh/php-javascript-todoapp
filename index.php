<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App - PHP and JavaScript</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="">Todo App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Me</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-3">
        <div id="message"></div>
        <h1>Add your todo</h1>
        <form>
            <div class="form-group">
                <label for="title">Todo title</label>
                <input type="email" class="form-control" id="title" placeholder="Enter your todo title">
            </div>
            <div class="form-group">
                <label for="description">Todo description</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter your todo description"></textarea>
            </div>
            <button type="button" class="btn btn-sm btn-danger" id="submitBtn">Add Todo</button>
        </form>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit note</h5>
                        <button type="button" class="close closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-todo-form">
                            <input type="hidden" id="snoEdit">
                            <div class="form-group">
                                <label for="titleEdit">Todo title</label>
                                <input type="text" class="form-control" id="titleEdit" placeholder="Enter your todo title">
                            </div>
                            <div class="form-group">
                                <label for="descriptionEdit">Todo description</label>
                                <textarea class="form-control" id="descriptionEdit" rows="3" placeholder="Enter your todo descriptiom"></textarea>
                            </div>
                            <button type="button" class="btn btn-sm btn-dark" id="updateBtn">Update todo</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-dark closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h1>Your todos</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody"><?php
            require_once 'config.php';
            $sql = "SELECT * FROM `todos`";
            $result = mysqli_query($conn, $sql);
            $index = 0;

            if (mysqli_num_rows($result) == 0) {
                echo '
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-center">No data available in the table</td>
                    <td></td>
                </tr>';
            }else{
                while ($row = mysqli_fetch_assoc($result)) {
                    $index++;
                    echo '
                    <tr>
                        <td>'.$index.'</td>
                        <td>'.$row["title"].'</td>
                        <td>'.$row["description"].'</td>
                        <td>
                            <button class="edit btn btn-sm btn-danger" id="'.$row["sno"].'">Edit</button>
                            <button class="delete btn btn-sm btn-danger" id="'.$row["sno"].'">Delete</button>
                        </td>
                    </tr>';
                }
            }?>
            
            </tbody>
        </table>
    </div>

    <!-- Script to handle client side -->
    <script src="script.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>