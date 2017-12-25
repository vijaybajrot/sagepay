<div id="content">
    <div id="contentHeader">Order Confirmation Page</div>
    <table class="formTable">
        <tr>
            <td colspan="2">
                <div class="subheader">Your current kit set-up</div>
            </td>
        </tr>
        <tr>
            <td class="fieldLabel">Vendor Name:</td>
            <td class="fieldData"><?php echo $vendorName; ?></td>
        </tr>
        <tr>
            <td class="fieldLabel">Default Currency:</td>
            <td class="fieldData"><?php echo $currency; ?></td>
        </tr>
        <tr>
            <td class="fieldLabel">URL of this kit:</td>
            <td class="fieldData">
                <a href="<?php echo $fullUrl ?>"><?php echo $fullUrl ?></a>
                <?php
                if (empty($siteFqdn))
                {
                ?>
                <br />(<span class="warning">warning</span>: this is a guessed value as no "siteFqdn" property is explicitly set in your configuration)
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="fieldLabel">Gateway:</td>
            <td class="fieldData">
                <a href="<?php echo $purchaseUrl; ?>"><?php echo $purchaseUrl; ?></a>
                <br/>(The Sage Pay Server URLs come ready configured for each environment but you can also override them if you wish)
            </td>
        </tr>
    </table>
    <?php
    if (!$isEncryptionPasswordOk)
    {
    ?>
    <p class="warning"><b>Could not perform a test encryption. Verify your encryption password is set correctly.</b></p>
    <?php } ?>
    <br>
    <br>
    <p>This page summarises the order details and customer information gathered on the previous screens.
        It is always a good idea to show your customers a page like this to allow them to go back and edit
        either basket or contact details.<br>
        <br>
        At this stage we also create the Form crypt field and a form to POST this information to
        the Sage Pay Gateway when the Proceed button is clicked.
    </p>
    <p>The URL to post to is:<b><?php echo $purchaseUrl ?></b></p>


    <div class="greyHzShadeBar">&nbsp;</div>
    <table class="formTable">
        <tr>
            <td colspan="5">
                <div class="subheader">Your Basket Contents</div>
            </td>
        </tr>
        <tr class="greybar">
            <td width="17%" align="center">Image</td>
            <td width="45%" align="left">Title</td>
            <td width="15%" align="right">Price</td>
            <td width="8%" align="right">Quantity</td>
            <td width="15%" align="right">Total</td>
        </tr>

       
        <tr>
            <td colspan="4" align="right">Delivery:</td>
            <td align="right"><?php echo $basket['deliveryGrossPrice'] . ' ' . $currency; ?></td>
        </tr>
        <tr>
            <td colspan="4" align="right"><strong>Total:</strong></td>
            <td align="right"><strong><?php echo $basket['totalGrossPrice'] . ' ' . $currency; ?></strong></td>
        </tr>
    </table>

    <table class="formTable">
        <tr>
            <td colspan="2">
                <div class="subheader">Your Billing Details</div>
            </td>
        </tr>
      
    
    </table>
  
        <table class="formTable">
            <tr>
                <td><div class="subheader">Your Form Crypt Post Contents</div></td>
            </tr>
            <tr>
                <td><p>The text below shows the unencrypted contents of the Form
                        Crypt field.  This application will not display this in LIVE mode.
                        If you wish to view the encrypted and encoded
                        contents view the source of this page and scroll to the bottom.
                        You'll find the submission FORM there.</p></td>
            </tr>
            <tr>
                <td class="code" style="padding: 10px;margin: 10px; background: whitesmoke;line-height: 40px; max-width: 800px;letter-spacing: 1px;">
                    <code >
                        <?php echo $queryString; ?>
                    </code>
                </td>
            </tr>
        </table>


    <div class="greyHzShadeBar">&nbsp;</div>

    <div class="formFooter">
        <table border="0" width="100%">
            <tr>
                <td width="50%" align="left">
                    <a href="#" title="Go back to the customer details page">
                        <input type="button" value="back">
                    </a>
                </td>
                <td width="50%" align="right">
                    <!-- ************************************************************************************* -->
                    <!-- This form is all that is required to submit the payment information to the system -->
                    <form action="<?php echo $purchaseUrl; ?>" method="post" id="SagePayForm" name="SagePayForm">
                        <?php
                        foreach ($request as $key => $value)
                        {
                            ?>
                            <input type="text" name="<?php echo $key; ?>" value="<?php echo htmlentities($value); ?>" />
                        <?php } ?>
                        <input type="submit" value="Pay Now">
                    </form>
                    <!-- ************************************************************************************* -->
                </td>
            </tr>
        </table>
    </div>
</div>
