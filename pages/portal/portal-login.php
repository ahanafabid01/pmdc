<?php require_once __DIR__ . '/../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login | Phulpur Mohila Degree College</title>
    <meta name="description" content="Secure portal login for Phulpur Mohila Degree College — Teacher and Administration access.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/pages/portal/css/login.css?v=<?= time() ?>">
</head>
<body>

<!-- ── Animated background ── -->
<div class="bg-layer" aria-hidden="true">
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
    <div class="particle p1"></div>
    <div class="particle p2"></div>
    <div class="particle p3"></div>
    <div class="particle p4"></div>
</div>

<!-- ── Page ── -->
<div class="page-wrap">

    <!-- LEFT — Branding -->
    <aside class="brand-panel" aria-label="College branding">
        <div class="brand-inner">

            <div class="brand-logo">
                <div class="logo-icon"><i class="fas fa-school"></i></div>
                <div class="logo-text">
                    <span class="logo-abbr">PMDC</span>
                    <span class="logo-full">Phulpur Mohila Degree College</span>
                </div>
            </div>

            <div class="brand-headline">
                <h1>Empowering<br><em>Education</em><br>Since 1980</h1>
                <p>A trusted institution shaping futures in Mymensingh — committed to academic excellence, discipline, and community growth.</p>
            </div>

            <div class="brand-stats">
                <div class="bstat">
                    <div class="bstat-val">40+</div>
                    <div class="bstat-lbl">Years of Excellence</div>
                </div>
                <div class="bstat-div"></div>
                <div class="bstat">
                    <div class="bstat-val">2,000+</div>
                    <div class="bstat-lbl">Students Enrolled</div>
                </div>
                <div class="bstat-div"></div>
                <div class="bstat">
                    <div class="bstat-val">100+</div>
                    <div class="bstat-lbl">Faculty Members</div>
                </div>
            </div>

            <div class="brand-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Secure Portal — Authorised Access Only</span>
            </div>

        </div>
    </aside>

    <!-- RIGHT — Auth Panel -->
    <main class="auth-panel" id="main-content">
        <div class="auth-inner">

            <!-- ══ STEP 1: Portal Selection ══ -->
            <div class="step" id="step-select">

                <div class="step-head">
                    <div class="step-icon"><i class="fas fa-grip-horizontal"></i></div>
                    <h2>Choose Your Portal</h2>
                    <p>Select the portal you want to access</p>
                </div>

                <div class="portal-cards" role="list">

                    <button class="pcard pcard--teacher"
                            id="btn-select-teacher"
                            aria-label="Continue as Teacher"
                            data-portal="teacher"
                            data-dest="<?= BASE_URL ?>/teacher"
                            data-color="blue"
                            data-label="Teacher Portal"
                            data-icon="fa-chalkboard-teacher">
                        <div class="pcard-icon-wrap">
                            <div class="pcard-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        </div>
                        <div class="pcard-body">
                            <div class="pcard-label">Teacher Portal</div>
                            <div class="pcard-desc">Students, results, gradebooks &amp; session records</div>
                        </div>
                        <div class="pcard-arrow"><i class="fas fa-chevron-right"></i></div>
                    </button>

                    <button class="pcard pcard--admin"
                            id="btn-select-admin"
                            aria-label="Continue as Admin"
                            data-portal="admin"
                            data-dest="<?= BASE_URL ?>/admin"
                            data-color="purple"
                            data-label="Administration"
                            data-icon="fa-user-shield">
                        <div class="pcard-icon-wrap">
                            <div class="pcard-icon"><i class="fas fa-user-shield"></i></div>
                        </div>
                        <div class="pcard-body">
                            <div class="pcard-label">Administration</div>
                            <div class="pcard-desc">System control, user management &amp; settings</div>
                        </div>
                        <div class="pcard-arrow"><i class="fas fa-chevron-right"></i></div>
                    </button>

                </div>

                <div class="step-footer">
                    <a href="<?= BASE_URL ?>/" class="back-link">
                        <i class="fas fa-arrow-left"></i> Back to Website
                    </a>
                    <span class="copy-year">&copy; <span id="currentYear"></span> PMDC</span>
                </div>

            </div><!-- /step-select -->


            <!-- ══ STEP 2: Login Form ══ -->
            <div class="step step--hidden" id="step-login" aria-live="polite">

                <!-- Portal identity bar -->
                <div class="portal-id-bar" id="portalIdBar">
                    <div class="pid-icon" id="pidIcon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div>
                        <div class="pid-label" id="pidLabel">Teacher Portal</div>
                        <div class="pid-sub">Sign in with your credentials</div>
                    </div>
                    <button class="pid-change" id="btnChangePortal" aria-label="Change portal selection" title="Change portal">
                        <i class="fas fa-exchange-alt"></i> Change
                    </button>
                </div>

                <!-- Login form -->
                <form class="login-form" id="loginForm" novalidate autocomplete="on">

                    <div class="form-group" id="fgUsername">
                        <label for="username">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <div class="input-wrap">
                            <input type="email"
                                   id="username"
                                   name="username"
                                   placeholder="Enter your email address"
                                   autocomplete="email"
                                   required>
                        </div>
                        <span class="field-err" id="err-username"></span>
                    </div>

                    <div class="form-group" id="fgPassword">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="input-wrap input-wrap--pass">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   required>
                            <button type="button" class="toggle-pass" id="togglePass" aria-label="Toggle password visibility" tabindex="-1">
                                <i class="fas fa-eye" id="togglePassIcon"></i>
                            </button>
                        </div>
                        <span class="field-err" id="err-password"></span>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" id="rememberMe" name="remember">
                            <span class="custom-check"></span>
                            Remember me
                        </label>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </div>

                    <!-- Error banner (shows on wrong credentials) -->
                    <div class="form-error-banner" id="loginError" role="alert" aria-hidden="true">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="loginErrorMsg">Invalid username or password.</span>
                    </div>

                    <button type="submit" class="btn-signin" id="btnSignIn">
                        <span class="btn-text">Sign In</span>
                        <span class="btn-spinner" aria-hidden="true"><i class="fas fa-circle-notch fa-spin"></i></span>
                        <i class="fas fa-arrow-right btn-arrow"></i>
                    </button>

                </form>

                <div class="step-footer">
                    <button class="back-link" id="btnBack" type="button">
                        <i class="fas fa-arrow-left"></i> All Portals
                    </button>
                    <span class="copy-year">&copy; <span class="year-val"></span> PMDC</span>
                </div>

            </div><!-- /step-login -->

        </div>
    </main>

</div><!-- /page-wrap -->

<script>window.BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>/pages/portal/js/login.js?v=<?= time() ?>"></script>
</body>
</html>
