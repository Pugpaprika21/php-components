<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Table Rows with jQuery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(function() {
            let rowNumber = 1;
            let endpoint = "http://localhost/php-components/api/users.php";
            let users = [];

            function loadUsers() {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: endpoint,
                    data: {},
                    success: function(response) {
                        users = response;
                    }
                });
            }

            function populateSelect(selectElement) {
                selectElement.append('<option selected disabled>select user</option>');
                users.forEach(user => {
                    selectElement.append(`<option value="${user.id}">${user.first_name} ${user.last_name}</option>`);
                });
            }

            $('#addRow').click(function() {
                let newRow = `<tr>
                    <td>
                        ${rowNumber}
                        <input type="hidden" name="user_id[]">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="first_name[]" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="last_name[]" readonly>
                    </td>
                    <td>
                        <select class="form-select user-select" aria-label="Default select example"></select>
                    </td>
                    <td><button class="btn btn-sm btn-danger removeRow">Remove</button></td>
                </tr>`;

                $('table tbody').append(newRow);
                populateSelect($('table tbody tr:last .user-select'));
                rowNumber++;
            });

            $('table').on('change', '.user-select', function() {
                let selectedUserId = $(this).val();
                let selectedUser = users.find(user => user.id == selectedUserId);
                let row = $(this).closest('tr');

                row.find('input[name="user_id[]"]').val(selectedUser.id);
                row.find('input[name="first_name[]"]').val(selectedUser.first_name);
                row.find('input[name="last_name[]"]').val(selectedUser.last_name);
                row.find('.first_name').text(selectedUser.first_name);
                row.find('.last_name').text(selectedUser.last_name);
            });

            $('table').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                rowNumber--;
                updateRowNumbers();
            });

            function updateRowNumbers() {
                $('table tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }
            loadUsers();
        });
    </script>
</head>

<body>
    <div class="container mt-4">
        <div class="btn">
            <button id="addRow" class="btn btn-sm btn-primary" type="button">Add Row</button>
        </div>

        <form action="../../api/getUser.php" method="post">
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>first_name</td>
                        <td>last_name</td>
                        <td>user</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>