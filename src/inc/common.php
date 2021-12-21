<!DOCTYPE html>
<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
        integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"
        integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
        <button class="ui button primary">
            Show Menu
        </button>
        <div class="ui left vertical inverted menu sidebar">
            <a class="item" href="home.php">
                Home
            </a>
            <a class="item" href="home.php">
                Posts
            </a>
            <a class="item">
                Profile
            </a>
            <a class="item" href="adminPanel.php">
                Admin
            </a>
        </div>
    <script>
        $('button').click(function () {
            $('.ui.sidebar')
                .sidebar('setting', 'transition', 'overlay')
                .sidebar('toggle')
        })
    </script>
    
<?php
    if (!isset($_SESSION['user'])){
        header('Location: http://localhost:8080/login.php');
    }
?>
</body>