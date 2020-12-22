<html>
    <head>
        <?php $this->load->view('email/css_email'); ?>
    </head>
    <body>
        <div class="container">

            <img class="photo" src="<?php echo base_url() ?>assets/img/logo.png">

            <br>

            <div class="header">
                <h1>Contacto</h1>
            </div>

            <p class="description"><?php echo $contact->name ?> - <?php echo $contact->email ?></p>
            <p class="description"><?php echo $contact->message ?></p>

        </div>
    </body>
</html>