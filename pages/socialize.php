<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/SocialStyle.css">
    <title>DMRC | Socialize</title>
</head>

<body>
    <header>
        <div class="head">
            <img src="../assets/images/logo.png" width="100px" height="39px">
            <div>
                <a href="home.php" class="link">Home</a>
                <a class="link" href="profile.php">My Profile</a>
                <a id="logout" class="link" href="../php/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <main>
        <section id="search-options">
            <div class="search-option">
                <h2>Search by Year of Retirement</h2>
                <form id="year-search-form">
                    <label for="retirement-year">Year of Retirement:</label>
                    <input type="number" id="retirement-year" name="retirement-year" required>
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="search-option">
                <h2>Search by Employee ID</h2>
                <form id="id-search-form">
                    <label for="employee-id">Employee ID:</label>
                    <input type="text" id="employee-id" name="employee-id" required>
                    <button type="submit">Search</button>
                </form>
            </div>
        </section>

        <section id="search-results">
            
        </section>
    </main>

    <script src="scripts.js"></script>

</body>

</html>