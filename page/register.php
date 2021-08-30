<div class="container">
    <div class="row justify-content-md-center">
        <div class="card mb-3 shadow p-3 bg-body rounded w-50">            
                <div class="row g-0">                    
                    <div class="col-md-12">
                        <div class="card-body">                        
                            <h3 class="card-title mb-3 text-center">Daftar</h3>
                            <form action="/register/store" method="POST">
                                <div class="form-group mb-3">
                                    <label for="" class="form-control-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Nama">
                                </div>                          
                                <div class="form-group mb-3">
                                    <label for="" class="form-control-label">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>                    
                                <div class="form-group mb-3">
                                    <label for="" class="form-control-label">Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                </div>                    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-control-label">Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-control-label">Confirm Password</label>
                                            <input type="password" name="confirm-password" class="form-control"  placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>                                                                    
                                <div class="d-flex justify-content-between">                                    
                                    <a href="/login" class="btn btn-outline-secondary">Masuk</a>                                                                          
                                    <button type="submit" name="register" class="btn btn-primary">Daftar</button>                                    
                                </div>                                
                            </form>
                        </div>  
                    </div>          
                </div>                                                                                   
        </div>                  
    </div>
</div>