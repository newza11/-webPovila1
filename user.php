<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/user.css">
    
    
</head>

<body>
    <div class="container">
        <?php include 'menu.php'; ?>

        

            <div class="details1" >
                <div class="recentOrders">
                    <div class="cardHeader " >
                        <h2>User Management</h2>
                        <button class="btn" onclick="showUserForm()">Add User</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <!-- User rows will be populated here via JavaScript dwdwdwwdw-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="userFormModal" style="display: none;">
        <div class="modalContent">
            <h2>User Form</h2>
            <form id="userForm">
                <input type="hidden" name="id" id="userId" >
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Save</button>
                <button type="button" onclick="hideUserForm()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function fetchUsers() {
            fetch('fetch_users.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('userTableBody');
                    tableBody.innerHTML = '';

                    data.forEach(user => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${user.id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>
                                <button onclick="editUser(${user.id}, '${user.username}', '${user.email}')">Edit</button>
                                <button onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        `;

                        tableBody.appendChild(row);
                    });
                });
        }

        function showUserForm(id = '', username = '', email = '') {
            document.getElementById('userId').value = id;
            document.getElementById('username').value = username;
            document.getElementById('email').value = email;
            document.getElementById('password').value = '';
            document.getElementById('userFormModal').style.display = 'block';
        }

        function hideUserForm() {
            document.getElementById('userFormModal').style.display = 'none';
        }

        document.getElementById('userForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    const url = data.id ? 'update_user.php' : 'add_user.php' ;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.error) {
                    alert('Error: ' + result.error);
                } else {
                    fetchUsers();
                    hideUserForm();
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
    .then(result => {
        if (result.error) {
            alert('Error: ' + result.error);
        } else {
            fetchUsers();
            hideUserForm();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        fetchUsers();
    </script>

    <style>
        .modalContent {
            background: white;
            padding: 20px;
            border-radius: 5px;
        }
        #userFormModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
    <script src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
