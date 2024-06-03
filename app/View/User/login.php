<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $model["title"] ?? "FurniTuu. Login" ?></title>

    <!-- Custom fonts for this template-->


    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous">
    </script>

</head>

<body class="bg-gradient-primary">
    <section class="vh-100" style="background-color: #1a453a;">
        <div class="container py-5 h-50">
            <?php if(isset($model['error'])) { ?>
                <div class="row">
                    <div class="alert alert-danger" role="alert">
                        <?= $model['error'] ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card h-1" style="border-radius: 1rem;">
                        <div class="row">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://previews.123rf.com/images/vadymvdrobot/vadymvdrobot1508/vadymvdrobot150800150/43198350-full-length-portrait-of-a-happy-man-standing-with-laptop-computer-isolated-on-a-white-background.jpg"
                                     alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form method="post" action="/users/login">

                                        <div class="d-flex align-items-center mb-2 pb-1">
                                            <p class="h1 fw-bold mb-0">Welcome Back!</p>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <input type="text"
                                                   name="id"
                                                   id="form2Example17"
                                                   class="form-control form-control-lg"
                                            />
                                            <label class="form-label" for="form2Example17">Id</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-2">
                                            <input type="password" name="password" id="form2Example27" class="form-control form-control-lg" />
                                            <label class="form-label" for="form2Example27">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="pb-lg-2" style="color: #393f81;">Don't have an account? <a href="register"
                                            style="color: #393f81;">Register here </a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

