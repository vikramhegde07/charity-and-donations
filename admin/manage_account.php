<?php
include '../includes/config.php';
include './includes/functions.php';

// Pagination setup
$limit = 10; // Number of entries per page
$total_transactions = getTotalTransactionCount();
$total_pages = ceil($total_transactions / $limit);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1
$offset = ($page - 1) * $limit;


// Pagination setup for campaigns
$campaign_limit = 5; // Number of entries per page
$total_campaigns = getTotalCampaignCount();
$total_campaign_pages = ceil($total_campaigns / $campaign_limit);

$campaign_page = isset($_GET['campaign_page']) ? (int)$_GET['campaign_page'] : 1;
$campaign_page = max($campaign_page, 1); // Ensure page is at least 1
$campaign_offset = ($campaign_page - 1) * $campaign_limit;

$transactions = getTransactions($limit, $offset);
$totals = getTotalAmountsPerCampaign($campaign_limit, $campaign_offset);

$user_email = isset($_GET['user_email']) ? $_GET['user_email'] : null;
$campaign_id = isset($_GET['campaign_id']) ? (int)$_GET['campaign_id'] : null;
$filtered_transactions = getFilteredTransactions($user_email, $campaign_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
</head>

<body>

    <?php include './includes/header.php'; ?>

    <div class="container" style="margin-top: 100px;">
        <div class="row">

            <div class="col-md-3"></div>

            <?php
            $sql = "SELECT count(id) as total from donation;";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc())
                $total = $row['total'];
            ?>
            <div class="col-md-6">
                <div class="block-48">
                    <span class="block-48-text-1">Total Donations</span>
                    <div class="block-48-counter ftco-number"><?php echo (int)$total; ?></div>
                    <p class="mb-0"><a href="#manage" class="btn btn-white px-3 py-2">Manage Accounts</a></p>
                </div>
            </div>

            <div class="col-md-3"></div>

        </div>
    </div>

    <div class="container">
        <h2 style="text-align: center;margin: 20px auto;font:bold">Accounting Section</h2>
        <h3>Total Amounts Per Campaign</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Campaign ID</th>
                    <th>Campaign Title</th>
                    <th>Total Amount Raised</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($totals as $total) : ?>
                    <tr>
                        <td><?php echo $total['campaign_id']; ?></td>
                        <td><?php echo $total['title']; ?></td>
                        <td><?php echo number_format($total['total_amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if ($campaign_page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?campaign_page=<?php echo $campaign_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_campaign_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $campaign_page) echo 'active'; ?>">
                        <a class="page-link" href="?campaign_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($campaign_page >= $total_campaign_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?campaign_page=<?php echo $campaign_page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <h3>All Transactions</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Campaign ID</th>
                    <th>Amount</th>
                    <th>Donor Name</th>
                    <th>Donor Email</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction) : ?>
                    <tr>
                        <td><?php echo $transaction['id']; ?></td>
                        <td><?php echo $transaction['campaign_id']; ?></td>
                        <td><?php echo number_format($transaction['amount'], 2); ?></td>
                        <td><?php echo $transaction['donor_name']; ?></td>
                        <td><?php echo $transaction['donor_email']; ?></td>
                        <td><?php echo $transaction['transaction_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="container mt-5">
        <h2>Transaction Management</h2>

        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="user_email">User Email</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Enter user email" value="<?php echo htmlspecialchars($user_email); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="campaign_id">Campaign ID</label>
                    <input type="number" class="form-control" id="campaign_id" name="campaign_id" placeholder="Enter campaign ID" value="<?php echo htmlspecialchars($campaign_id); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <h3 class="mt-4">Filtered Transactions</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Campaign ID</th>
                    <th>Amount</th>
                    <th>Donor Name</th>
                    <th>Donor Email</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($filtered_transactions)) : ?>
                    <?php foreach ($filtered_transactions as $transaction) : ?>
                        <tr>
                            <td><?php echo $transaction['id']; ?></td>
                            <td><?php echo $transaction['campaign_id']; ?></td>
                            <td><?php echo number_format($transaction['amount'], 2); ?></td>
                            <td><?php echo $transaction['donor_name']; ?></td>
                            <td><?php echo $transaction['donor_email']; ?></td>
                            <td><?php echo $transaction['transaction_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>