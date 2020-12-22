<div class="container">
    <div class="row">
        <div class="col-md-12">

            <?php if (validation_errors() !== ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php if ($send): ?>
                <div class="alert alert-success mt-3">		
                    Su mensaje ha sido enviado
                </div>
            <?php endif ?>


            <div class="card">
                <div class="card-header">
                    <h3 class="section-title">Contacto</h3>
                </div>
                <div class="card-body">
                    <p class="lead">
                        Si tiene preguntas, ¡no dude en contactar!
                    </p>

                    <form id="contact" name="contact" method="post" class="text-left" action="<?php echo base_url() ?>contacto/contacto_enviado">
                        <fieldset>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="name">Nombre<span class="required">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name" size="30" value="<?php echo $name ?>" required minlength="2" maxlength="100"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="email">Email<span class="required">*</span></label>
                                        <input class="form-control" type="text" name="email" id="email" size="30" value="<?php echo $email ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Mensaje<span class="required">*</span></label>
                                <textarea class="form-control" name="message" id="message" required required minlength="2" maxlength="800"><?php echo $message ?></textarea>
                            </div>
                            <div>
                                <input id="submit" type="submit" name="submit" value="Enviar" class="btn btn-lg btn-success"/>
                            </div>
                        </fieldset>


                    </form>
                </div>
            </div>

        </div>
    </div>
</div>