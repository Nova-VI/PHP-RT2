<div class="logout-page">
    <h1 style="font-size: 3em;">Are you sure you want to log out? </h1>
    <span>
        <button onclick="setActive(list[0])" name="no">No</button>
        <button type="submit" name="unsetSession" onclick="window.location.href='logout.action.php'">Yes</button>
    </span>
</div>
<style>
    .logout-page {
        padding: 50px;
        margin: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

    }

    .logout-page button {
        padding: 10px 20px;
        margin: 10px;
        border: 2px solid black;
        border-radius: 5px;
        background-color: #f1f1f1;
        cursor: pointer;
        flex-grow: 1;
        margin: 20px;
        transition: .5s;
        font-size: 2em;
    }

    .logout-page button[name="unsetSession"] {
        border: 2px solid red;
        color: red;
    }

    .logout-page button[name="no"]:hover {
        background-color: black;
        color: white
    }

    .logout-page button[name="unsetSession"]:hover {
        background-color: red;
        color: white
    }

    .logout-page button:active {
        background-color: #ccc;
    }

    .logout-page h1 {
        margin-bottom: 20px;
    }

    .logout-page span {
        margin: 40px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>