<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
        integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"
        integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>


<button style="position: fixed; margin: 1% 1%" class="ui left floated large button basic primary">
    <i class="fa-solid fa-bars"></i>
</button>
<div class="ui left vertical inverted labeled icon menu sidebar">
    <a class="item" href="home.php">
    <i class="home icon"></i>
        Home
    </a>
    <a class="item" href="new.php">
    <i class="plus square outline icon"></i>
        Add Post
    </a>
    <a class="item" href="account.php">
    <i class="user circle icon"></i>
        Profile
    </a>
    <a class="item" href="adminPanel.php">
    <i class="shield alternate icon"></i>
        Admin
    </a>
</div>

<script type="text/javascript">
    $('button').click(function () {
        $('.ui.sidebar')
            .sidebar('toggle')
    })
</script>

<?php
    if (!isset($_SESSION['user'])){
        header('Location: http://localhost:8080/login.php');
    }
?>