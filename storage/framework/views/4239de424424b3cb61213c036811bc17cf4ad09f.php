<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <title><?php echo e($invoice->name); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        h1, h2, h3, h4, span, p, div {
            font-family: DejaVu Sans;
        }


    </style>
</head>
<body>
<div style="display: block;clear: both">
    <div style="float: left; width:250pt;">
        <img class="img-rounded" height="50px"
             src="<?php echo e(asset('storage/logos/'.config('logo_b_image'))); ?>">
    </div>
    <div style="float: right;width: 180pt;">
        <h5>Date: <b> <?php echo e($invoice->date->formatLocalized('%A %d %B %Y')); ?></b></h5>
        <?php if($invoice->number): ?>
            <h5>Invoice #: <b><?php echo e(strval($invoice->number)); ?></b></h5>
        <?php endif; ?>
    </div>
</div>
<div style="display: inline-block;clear: both;width: 100%;">
    <hr>

    <div style="width:300pt; float:left;">
        <h4>Business Details:</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php if(config('contact_data') != ""): ?>
                    <?php
                        $contact_data = contact_data(config('contact_data'));
                    ?>
                    <h4 style="font-weight: bold;"><?php echo e(env('APP_NAME')); ?></h4>

                    <?php if($contact_data["primary_address"]["status"] == 1): ?>
                        <span>Address: <?php echo e($contact_data["primary_address"]["value"]); ?> </span><br>
                    <?php endif; ?>

                    <?php if($contact_data["primary_phone"]["status"] == 1): ?>
                        
                        <span style="font-family: Helvetica, Arial, sans-serif;">Contact No.: <?php echo e($contact_data["primary_phone"]["value"]); ?></span>
                        <br>
                    <?php endif; ?>

                    <?php if($contact_data["primary_email"]["status"] == 1): ?>
                        <span> Email : <?php echo e($contact_data["primary_email"]["value"]); ?> </span><br>
                    <?php endif; ?>
                <?php else: ?>
                    <i>No business details</i><br/>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div style="float: right; width:200pt;height: auto;display: inline-block">
        <h4>Customer Details:</h4>
        <div class="panel panel-default" style="padding: 15px;padding-top: 0px">
            <?php echo $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : ''; ?>

            <h4 style="font-weight: bold; font-family: DejaVu Sans;"> <?php echo e($invoice->customer_details->get('name')); ?></h4>
            <span>Email :</span> <?php echo e($invoice->customer_details->get('email')); ?>

        </div>
    </div>
</div>

<div style="clear:both;display: block;">
    <h4>Items:</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Item Name</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $key++ ?>
            <tr>
                <td><?php echo e($key); ?></td>
                <td><?php echo e($item->get('id')); ?></td>
                <td style=" font-family: DejaVu Sans;"><?php echo e($item->get('name')); ?></td>
                <td class="text-right"><?php echo e($item->get('totalPrice')); ?> <?php echo e($invoice->formatCurrency()->symbol); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="clear:both; position:relative;">

        
        

        
        <div style="margin-left: 300pt;">
            <h4>Total:</h4>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><b>Subtotal</b></td>
                    <td class="text-right"><?php echo e($invoice->subTotalPriceFormatted()); ?> <?php echo e($invoice->formatCurrency()->symbol); ?></td>
                </tr>
                <?php if($invoice->discount != null): ?>
                    <tr>
                        <td><b> - Discount</b></td>
                        <td class="text-right"><?php echo e($invoice->discount); ?> <?php echo e($invoice->formatCurrency()->symbol); ?></td>
                    </tr>
                <?php endif; ?>
                <?php if($invoice->taxData != null): ?>
                    <?php $__currentLoopData = $invoice->taxData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                + <?php echo e($tax['name']); ?>

                            </td>
                            <td class="text-right"><?php echo e(number_format( $tax['amount'],2)); ?> <?php echo e($invoice->formatCurrency()->symbol); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td class="text-right"><b><?php echo e($invoice->total); ?> <?php echo e($invoice->formatCurrency()->symbol); ?></b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($invoice->footnote): ?>
    <br/><br/>
    <div class="well">
        <?php echo e($invoice->footnote); ?>

    </div>
<?php endif; ?>
</body>
</html>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/vendor/invoices/default.blade.php ENDPATH**/ ?>