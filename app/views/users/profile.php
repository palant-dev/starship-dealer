<?php require APPROOT . '/views/templates/front/header.php'; ?>

<!-- Page Content -->
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">My Profile</h1>
            <?php flash('profile_success'); ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                    <h3 class="card-title mt-3"><?php echo $data['user']->username; ?></h3>
                    <p class="card-text">Member since: <?php echo date('F Y', strtotime($data['user']->created_at)); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Account Information</h4>
                    <form action="<?php echo URLROOT; ?>/users/updateProfile" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['user']->username; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="email" name="email" value="<?php echo $data['user']->email; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>

                        <hr>
                        <h5>Change Password</h5>
                        <p class="text-muted small">Leave blank if you don't want to change your password</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control <?php echo (!empty($data['current_password_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="current_password" name="current_password">
                            <span class="invalid-feedback"><?php echo $data['current_password_err']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="new_password" name="new_password">
                            <span class="invalid-feedback"><?php echo $data['new_password_err']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                   id="confirm_password" name="confirm_password">
                            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="card-title">Recent Orders</h4>
                    <?php if(!empty($data['orders'])) : ?>
                        <?php foreach($data['orders'] as $order) : ?>
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Order #<?php echo $order->order_id; ?></strong>
                                        <span class="text-muted ms-2"><?php echo date('M d, Y', strtotime($order->order_date)); ?></span>
                                    </div>
                                    <span class="badge bg-success">$<?php echo number_format($order->order_amount, 2); ?></span>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($order->items as $item) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $item->product_title; ?>
                                                        </td>
                                                        <td>$<?php echo number_format($item->product_price, 2); ?></td>
                                                        <td><?php echo $item->quantity; ?></td>
                                                        <td>$<?php echo number_format($item->product_price * $item->quantity, 2); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No orders found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>