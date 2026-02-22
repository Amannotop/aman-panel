<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-12">
        <?= $this->include('Layout/msgStatus') ?>
    </div>
    
    
    
    
    
    
    
        <div class="col-lg-8">
        <div class="card mb-3">
            
            <div class="card-header text-white bg-info">
                Push Notification
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover text-center">
                        <tbody>
    
 <div class="card-body">
     
     
     
     
     
                 <?= form_open('sendnoty') ?>
                
                    <div class="col-lg-12 mb-3">
                        <label for="devices" class="form-label">Title</small></label>
                          <input type="text" class="form-control mt-2" value="https://t.me/cheatbot_tele" name="name" id="name">
                      
                    </div>
                    
                    
                     <div class="col-lg-12 mb-3">
                        <label for="devices" class="form-label">Message</small></label>
                          <input type="text" class="form-control mt-2" value="" name="message" id="message">
                      
                    </div>
                    
                     <div class="col-lg-12 mb-3">
                        <label for="devices" class="form-label">Image Link</small></label>
                          <input type="text" class="form-control mt-2" value="https://" name="link" id="link">
                      
                    </div>
                    
                    
                    
                     <div class="col-lg-12 mb-3">
                        <label for="devices" class="form-label">Icon Color (Hex Formate) </small></label>
                         <input type="text" class="form-control mt-2" name="color" value="#FF0000" id="color">
                      
                    </div>
                    
                    
                    
                    
                    <div class="col-lg-6">
                       <button type="submit" class="btn btn-outline-info"> Send Push Notification</button>
                    </div>
                   
                   
                   
                   <?= form_close() ?>

    
    
    
    
    
    
     </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    
    

    
     
    
<?= $this->endSection() ?>

