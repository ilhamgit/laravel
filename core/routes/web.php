<?php

use Illuminate\Support\Facades\Route;

use app\Http\Controllers;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::namespace('Gateway')->prefix('ipn')->name('ipn.')->group(function () {
    Route::post('paypal', 'Paypal\ProcessController@ipn')->name('Paypal');
    Route::get('paypal-sdk', 'PaypalSdk\ProcessController@ipn')->name('PaypalSdk');
    Route::post('perfect-money', 'PerfectMoney\ProcessController@ipn')->name('PerfectMoney');
    Route::post('stripe', 'Stripe\ProcessController@ipn')->name('Stripe');
    Route::post('stripe-js', 'StripeJs\ProcessController@ipn')->name('StripeJs');
    Route::post('stripe-v3', 'StripeV3\ProcessController@ipn')->name('StripeV3');
    Route::post('skrill', 'Skrill\ProcessController@ipn')->name('Skrill');
    Route::post('paytm', 'Paytm\ProcessController@ipn')->name('Paytm');
    Route::post('payeer', 'Payeer\ProcessController@ipn')->name('Payeer');
    Route::post('paystack', 'Paystack\ProcessController@ipn')->name('Paystack');
    Route::post('voguepay', 'Voguepay\ProcessController@ipn')->name('Voguepay');
    Route::get('flutterwave/{trx}/{type}', 'Flutterwave\ProcessController@ipn')->name('Flutterwave');
    Route::post('razorpay', 'Razorpay\ProcessController@ipn')->name('Razorpay');
    Route::post('instamojo', 'Instamojo\ProcessController@ipn')->name('Instamojo');
    Route::get('blockchain', 'Blockchain\ProcessController@ipn')->name('Blockchain');
    Route::get('blockio', 'Blockio\ProcessController@ipn')->name('Blockio');
    Route::post('coinpayments', 'Coinpayments\ProcessController@ipn')->name('Coinpayments');
    Route::post('coinpayments-fiat', 'Coinpayments_fiat\ProcessController@ipn')->name('CoinpaymentsFiat');
    Route::post('coingate', 'Coingate\ProcessController@ipn')->name('Coingate');
    Route::post('coinbase-commerce', 'CoinbaseCommerce\ProcessController@ipn')->name('CoinbaseCommerce');
    Route::get('mollie', 'Mollie\ProcessController@ipn')->name('Mollie');
    Route::post('cashmaal', 'Cashmaal\ProcessController@ipn')->name('Cashmaal');
    Route::post('authorize-net', 'AuthorizeNet\ProcessController@ipn')->name('AuthorizeNet');
    Route::post('2check-out', 'TwoCheckOut\ProcessController@ipn')->name('TwoCheckOut');
    Route::post('mercado-pago', 'MercadoPago\ProcessController@ipn')->name('MercadoPago');
});

// User Support Ticket
Route::prefix('ticket')->group(function () {
    Route::get('/', 'TicketController@supportTicket')->name('ticket');
    Route::get('/new', 'TicketController@openSupportTicket')->name('ticket.open');
    Route::post('/create', 'TicketController@storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'TicketController@viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'TicketController@replyTicket')->name('ticket.reply');
    Route::get('/download/{ticket}', 'TicketController@ticketDownload')->name('ticket.download');
});


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications','AdminController@notifications')->name('notifications');
        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications/read-all','AdminController@readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report','AdminController@requestReport')->name('request.report');
        Route::post('request-report','AdminController@reportSubmit');
        Route::get('system-info','AdminController@systemInfo')->name('system.info');

        // Mange Category
        Route::get('categories', 'CategoryController@index')->name('category.index');
        Route::post('category/store/{id?}', 'CategoryController@store')->name('category.store');

        // Mange League
        Route::get('leagues', 'LeagueController@index')->name('league.index');
        Route::post('league/store/{id?}', 'LeagueController@store')->name('league.store');

        // Mange Matches
        Route::get('matches/all', 'MatchController@index')->name('match.index');
        Route::get('match/running', 'MatchController@index')->name('match.running');
        Route::get('match/upcoming', 'MatchController@index')->name('match.upcoming');
        Route::get('match/completed', 'MatchController@index')->name('match.completed');

        Route::post('match/store/{id?}', 'MatchController@store')->name('match.store');

        // Mange Question
        Route::get('questions/{match_id}', 'QuestionsController@index')->name('question.index');
        Route::post('question/store/{id?}', 'QuestionsController@store')->name('question.store');

        // Mange Option
        Route::get('options/{condition_id}', 'OptionsController@index')->name('option.index');
        Route::post('option/store/{id?}', 'OptionsController@store')->name('option.store');

        // Manage Option From Outside of Match Menu
        Route::get('make-winner', 'MakeWinnerController@questions')->name('betting.match.index');
        Route::get('betting-match/search', 'MakeWinnerController@bettingMatchSearch')->name('betting.match.search');
        Route::post('all-option/win', 'MakeWinnerController@optionWin')->name('all.option.win');
        Route::post('all-option/abandoned', 'MakeWinnerController@optionAbandoned')->name('all.option.abandoned');
        Route::post('all-option/loser', 'MakeWinnerController@optionLoser')->name('all.option.loser');

        // Referral
        Route::get('referral', 'ReferralController@index')->name('referral.index');
        Route::post('referral/store', 'ReferralController@store')->name('referral.store');
        Route::get('referral-status/update/{type}', 'ReferralController@referralStatusUpdate')->name('referral.status.update');

        // Mange Bet
        Route::get('bets/all', 'BetsController@index')->name('bet.index');
        Route::get('bets/pending', 'BetsController@index')->name('bet.pending');
        Route::get('bets/won', 'BetsController@index')->name('bet.win');
        Route::get('bets/lose', 'BetsController@index')->name('bet.lose');
        Route::get('bets/refunded', 'BetsController@index')->name('bet.refunded');

        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
        Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
        Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
        Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
        Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
        Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
        Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');
        Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');

        Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
        Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
        Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
        Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.add.sub.balance');
        Route::get('user/send-email/{id}', 'ManageUsersController@showEmailSingleForm')->name('users.email.single');
        Route::post('user/send-email/{id}', 'ManageUsersController@sendEmailSingle')->name('users.email.single');
        Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
        Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
        Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
        Route::get('user/deposits/via/{method}/{type?}/{userId}', 'ManageUsersController@depositViaMethod')->name('users.deposits.method');
        Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
        Route::get('user/withdrawals/via/{method}/{type?}/{userId}', 'ManageUsersController@withdrawalsViaMethod')->name('users.withdrawals.method');
        // Login History
        Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');
        Route::get('users/email-log/{id}', 'ManageUsersController@emailLog')->name('users.email.log');
        Route::get('users/email-details/{id}', 'ManageUsersController@emailDetails')->name('users.email.details');

        // Bets For Individual User
        Route::get('user/bets/{id}', 'ManageUsersController@bets')->name('users.bets');

        // Referral Users For Individual User
        Route::get('user/referrals/{id}', 'ManageUsersController@referrals')->name('users.referrals');

        // Commission Log Of Individual User
        Route::get('user/commissions/deposit/{id}', 'ManageUsersController@referralCommissionsDeposit')->name('users.commissions.deposit');
        Route::get('user/commissions/bet/{id}', 'ManageUsersController@referralCommissionsBet')->name('users.commissions.bet');
        Route::get('user/commissions/win/{id}', 'ManageUsersController@referralCommissionsWin')->name('users.commissions.win');

        // Subscriber
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('subscriber/send-email', 'SubscriberController@sendEmailForm')->name('subscriber.sendEmail');
        Route::post('subscriber/remove', 'SubscriberController@remove')->name('subscriber.remove');
        Route::post('subscriber/send-email', 'SubscriberController@sendEmail')->name('subscriber.sendEmail');


        // Deposit Gateway
        Route::name('gateway.')->prefix('gateway')->group(function(){
            // Automatic Gateway
            Route::get('automatic', 'GatewayController@index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'GatewayController@edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'GatewayController@update')->name('automatic.update');
            Route::post('automatic/remove/{code}', 'GatewayController@remove')->name('automatic.remove');
            Route::post('automatic/activate', 'GatewayController@activate')->name('automatic.activate');
            Route::post('automatic/deactivate', 'GatewayController@deactivate')->name('automatic.deactivate');

            // Manual Methods
            Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
            Route::get('manual/new', 'ManualGatewayController@create')->name('manual.create');
            Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'ManualGatewayController@edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
            Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
            Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
        });

        // DEPOSIT SYSTEM
        Route::name('deposit.')->prefix('deposit')->group(function(){
            Route::get('/', 'DepositController@deposit')->name('list');
            Route::get('pending', 'DepositController@pending')->name('pending');
            Route::get('rejected', 'DepositController@rejected')->name('rejected');
            Route::get('approved', 'DepositController@approved')->name('approved');
            Route::get('successful', 'DepositController@successful')->name('successful');
            Route::get('details/{id}', 'DepositController@details')->name('details');

            Route::post('reject', 'DepositController@reject')->name('reject');
            Route::post('approve', 'DepositController@approve')->name('approve');
            Route::get('via/{method}/{type?}', 'DepositController@depositViaMethod')->name('method');
            Route::get('/{scope}/search', 'DepositController@search')->name('search');
            Route::get('date-search/{scope}', 'DepositController@dateSearch')->name('dateSearch');

        });

        // WITHDRAW SYSTEM
        Route::name('withdraw.')->prefix('withdraw')->group(function(){
            Route::get('pending', 'WithdrawalController@pending')->name('pending');
            Route::get('approved', 'WithdrawalController@approved')->name('approved');
            Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
            Route::get('log', 'WithdrawalController@log')->name('log');
            Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
            Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
            Route::get('date-search/{scope}', 'WithdrawalController@dateSearch')->name('dateSearch');
            Route::get('details/{id}', 'WithdrawalController@details')->name('details');
            Route::post('approve', 'WithdrawalController@approve')->name('approve');
            Route::post('reject', 'WithdrawalController@reject')->name('reject');

            // Withdraw Method
            Route::get('method/', 'WithdrawMethodController@methods')->name('method.index');
            Route::get('method/create', 'WithdrawMethodController@create')->name('method.create');
            Route::post('method/create', 'WithdrawMethodController@store')->name('method.store');
            Route::get('method/edit/{id}', 'WithdrawMethodController@edit')->name('method.edit');
            Route::post('method/edit/{id}', 'WithdrawMethodController@update')->name('method.update');
            Route::post('method/activate', 'WithdrawMethodController@activate')->name('method.activate');
            Route::post('method/deactivate', 'WithdrawMethodController@deactivate')->name('method.deactivate');
        });

        // Report
        Route::get('report/bet-report', 'ReportController@betReport')->name('report.bet');
        Route::get('report/bet-report/search', 'ReportController@betReportSearch')->name('report.bet.search');
        Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
        Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
        Route::get('report/reward', 'ReportController@loginHistory')->name('report.reward');
        Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');
        Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');

        //Commission Report
        Route::get('report/commissions/deposit', 'ReportController@commissionsDeposit')->name('report.commissions.deposit');
        Route::get('report/commissions/bet', 'ReportController@commissionsBet')->name('report.commissions.bet');
        Route::get('report/commissions/win', 'ReportController@commissionsWin')->name('report.commissions.win');
        Route::get('report/commissions/search', 'ReportController@commissionsSearch')->name('report.commissions.search');


        // Game Configuration
        Route::get('configuration/referral', 'ConfigurationController@referralBet')->name('configuration.referral');
        Route::get('configuration/referral/update/autorace', 'ConfigurationController@updateBetsAutoRaceForm')->name('configuration.referral.autorace');
        Route::get('configuration/referral/update/raced1', 'ConfigurationController@updateBetsRaceD1Form')->name('configuration.referral.raced1');
        Route::get('configuration/referral/update/raced2', 'ConfigurationController@updateBetsRaceD2Form')->name('configuration.referral.raced2');
        Route::get('configuration/referral/update/raced3', 'ConfigurationController@updateBetsRaceD3Form')->name('configuration.referral.raced3');
        Route::post('configuration/referral/update', 'ConfigurationController@updateBets');

        Route::get('configuration/season', 'ConfigurationController@currentSeason')->name('configuration.season');
        Route::get('configuration/season/update', 'ConfigurationController@updateSeasonForm')->name('configuration.season.update');
        Route::post('configuration/season/update', 'ConfigurationController@updateSeason');

        Route::get('configuration/rewards', 'ConfigurationController@rewards')->name('configuration.rewards');
        Route::get('configuration/rewards/update/autorace', 'ConfigurationController@updateRewardsAutoRaceForm')->name('configuration.rewards.autorace');
        Route::get('configuration/rewards/update/raced1', 'ConfigurationController@updateRewardsRaceD1Form')->name('configuration.rewards.raced1');
        Route::get('configuration/rewards/update/raced2', 'ConfigurationController@updateRewardsRaceD2Form')->name('configuration.rewards.raced2');
        Route::get('configuration/rewards/update/raced3', 'ConfigurationController@updateRewardsRaceD3Form')->name('configuration.rewards.raced3');
        Route::get('configuration/rewards/update/luckyraces', 'ConfigurationController@updateRewardsLuckyRaceForm')->name('configuration.rewards.luckyraces');
        Route::get('configuration/rewards/update/superraces', 'ConfigurationController@updateRewardsSuperRaceForm')->name('configuration.rewards.superraces');
        Route::post('configuration/rewards/update', 'ConfigurationController@updateRewards');

        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.importLang');

        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');

        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');
        Route::get('optimize', 'GeneralSettingController@optimize')->name('setting.optimize');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css','GeneralSettingController@customCss')->name('setting.custom.css');
        Route::post('custom-css','GeneralSettingController@customCssSubmit');

        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('setting.cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');

        // Plugin
        Route::get('extensions', 'ExtensionController@index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'ExtensionController@update')->name('extensions.update');
        Route::post('extensions/activate', 'ExtensionController@activate')->name('extensions.activate');
        Route::post('extensions/deactivate', 'ExtensionController@deactivate')->name('extensions.deactivate');

        // Email Setting
        Route::get('email-template/global', 'EmailTemplateController@emailTemplate')->name('email.template.global');
        Route::post('email-template/global', 'EmailTemplateController@emailTemplateUpdate')->name('email.template.global');
        Route::get('email-template/setting', 'EmailTemplateController@emailSetting')->name('email.template.setting');
        Route::post('email-template/setting', 'EmailTemplateController@emailSettingUpdate')->name('email.template.setting');
        Route::get('email-template/index', 'EmailTemplateController@index')->name('email.template.index');
        Route::get('email-template/{id}/edit', 'EmailTemplateController@edit')->name('email.template.edit');
        Route::post('email-template/{id}/update', 'EmailTemplateController@update')->name('email.template.update');
        Route::post('email-template/send-test-mail', 'EmailTemplateController@sendTestMail')->name('email.template.test.mail');

        // SMS Setting
        Route::get('sms-template/global', 'SmsTemplateController@smsTemplate')->name('sms.template.global');
        Route::post('sms-template/global', 'SmsTemplateController@smsTemplateUpdate')->name('sms.template.global');
        Route::get('sms-template/setting','SmsTemplateController@smsSetting')->name('sms.templates.setting');
        Route::post('sms-template/setting', 'SmsTemplateController@smsSettingUpdate')->name('sms.template.setting');
        Route::get('sms-template/index', 'SmsTemplateController@index')->name('sms.template.index');
        Route::get('sms-template/edit/{id}', 'SmsTemplateController@edit')->name('sms.template.edit');
        Route::post('sms-template/update/{id}', 'SmsTemplateController@update')->name('sms.template.update');
        Route::post('email-template/send-test-sms', 'SmsTemplateController@sendTestSMS')->name('sms.template.test.sms');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');

        // Frontend
        Route::name('frontend.')->prefix('frontend')->group(function () {
            Route::get('templates', 'FrontendController@templates')->name('templates');
            Route::post('templates', 'FrontendController@templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
            Route::post('remove', 'FrontendController@remove')->name('remove');

            // Page Builder
            Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
            Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/

Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('check-mail', 'Auth\RegisterController@checkUser')->name('checkUser');

    Route::group(['middleware' => ['guest']], function () {
        Route::get('register/{reference}', 'Auth\RegisterController@referralRegister')->name('refer.register');
    });

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('change.password');
            Route::post('change-password', 'UserController@submitPassword');

            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');

            // Deposit
            Route::any('/deposit', 'Gateway\PaymentController@deposit')->name('deposit');
            Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
            Route::any('deposit/history', 'UserController@depositHistory')->name('deposit.history');

            // Withdraw
            Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history', 'UserController@withdrawLog')->name('withdraw.history');

            // Bet Placing
            Route::get('/bets/{type?}', 'BetController@index')->name('bet.index');
            Route::post('/bet/store', 'BetController@betStore')->name('bet.store');

            // Referral
            Route::get('referral/commissions/deposit', 'UserController@commissionsDeposit')->name('referral.commissions.deposit');
            Route::get('referral/commissions/placed-bet', 'UserController@commissionsBet')->name('referral.commissions.bet');
            Route::get('referral/commissions/won-bet', 'UserController@commissionsWin')->name('referral.commissions.win');
            Route::get('referred/users/{level?}', 'UserController@refMy')->name('referral.users');

            // Transaction
            Route::get('/transactions', 'UserController@transactions')->name('transactions');

            //wallet
            Route::get('userbalance', 'UserController@userwallet')->name('userbalance');


            //horses,items and mysterybox

            Route::get('horses', 'UserController@horses')->name('horses');
            
            Route::get('horse-stat', 'UserController@horseStats')->name('horse-stat');
            Route::post('verify-horse', 'UserController@verifyHorse');
            Route::post('horse-rent', 'UserController@horseRent');
            Route::post('horse-stat', 'UserController@verifyBreed');

            Route::get('horse-train', 'UserController@horseTrain')->name('horse-train');

            Route::get('breed', 'UserController@horseBreed')->name('breed');
            Route::post('nft-verify', 'UserController@nftVerify')->name('nft-verify');

            Route::get('items', 'UserController@items')->name('items');
            Route::post('verify-item', 'UserController@verifyItem');
            Route::get('item-stat', 'UserController@item_stats')->name('item-stat');


            Route::get('canteen', 'UserController@canteen')->name('canteen');

            Route::get('mystery-box', 'UserController@boxes')->name('boxes');

            Route::get('draw-box', 'UserController@boxesDraw')->name('draw-box');

            Route::get('purchase-box', 'UserController@boxesPurchase')->name('purchase-box');
            Route::post('purchase-box', 'UserController@submitPurchase');


            Route::get('super-breed', 'UserController@superBreed')->name('super-breed');
            Route::post('verify-super-breed', 'UserController@verifySuperHorse');


            Route::get('superhorse-stat', 'UserController@shStats')->name('superhorse-stat');
            Route::get('superhorse-breed', 'UserController@superHorseBreed')->name('superhorse-breed');
            Route::post('shbreed-verify', 'UserController@shBreedVerify')->name('shbreed-verify');
            Route::post('superhorse-stat', 'UserController@verifyBreed');

            //query
            Route::get('querytest', 'SocketController@query');

            //summary

            Route::get('game-rewards', 'UserController@gameRewards')->name('game-rewards');
            Route::post('claim-reward', 'UserController@rewardClaim');
            Route::get('game-deposit', 'UserController@gameDeposit')->name('game-deposit');
            Route::get('game-withdrawal', 'UserController@gameWithdrawal')->name('game-withdrawal');


            //match
            Route::get('join-match', 'UserController@joinMatch')->name('join-match');
            Route::post('verify-match', 'UserController@verifyMatch');
            Route::get('match-results', 'UserController@matchResults')->name('match-results');
            Route::get('list-result', 'UserController@listResults')->name('list-result');
            Route::get('list-replay', 'UserController@listReplay')->name('list-replay');

            Route::get('match-registraion', 'UserController@matchRegister')->name('match-registraion');
            Route::post('match-registraion', 'UserController@matchHorseVerify');


            //bet
            Route::get('place-bet', 'UserController@placeBet')->name('place-bet');
            Route::get('match/{id}/bet', 'UserController@matchBet')->name('match-bet');
            Route::post('match/{id}/place', 'UserController@matchPlaceBet')->name('match-place-bet');

            //query
            Route::post('bridge/swap-g', 'QueryController@swap_mbtc_g')->name('bridge.swap-g');
            Route::post('bridge/swap-mbtc', 'QueryController@swap_g_mbtc')->name('bridge.swap-mbtc');
            Route::post('bridge/super-breed', 'QueryController@super_breed')->name('bridge.super-breed');
            Route::post('bridge/standard-breed', 'QueryController@standard_breed')->name('bridge.standard-breed');
            Route::post('bridge/update-superhorse', 'QueryController@update_superhorse')->name('bridge.update-superhorse');
        });
    });
});

// League Matches
Route::get('leagues/{slug}/{id}', 'SiteController@matchesByLeague')->name('league.matches');

// Match Questions
Route::get('match/{slug}/{id}', 'SiteController@matchDetails')->name('match.details');

// Subscriber Store
Route::post('subscriber', 'SiteController@subscriberStore')->name('subscriber.store');

// Policy Details
Route::get('policy/{slug}/{id}', 'SiteController@policyDetails')->name('policy.details');

// Contact
Route::get('/contact', 'SiteController@contact')->name('contact');
Route::post('/contact', 'SiteController@contactSubmit');

// Language
Route::get('/change/{lang?}', 'SiteController@changeLanguage')->name('lang');

// Cookie
Route::get('/cookie-accept', 'SiteController@cookieAccept')->name('cookie.accept');

// Blog
Route::get('blogs', 'SiteController@blogs')->name('blogs');
Route::get('blog/{id}/{slug}', 'SiteController@blogDetails')->name('blog.details');

Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholder.image');
Route::get('/{slug}', 'SiteController@pages')->name('pages');
Route::get('/', 'SiteController@index')->name('home');
Route::get('new-home', 'SiteController@newHome')->name('new-home');

//ether

Route::get('web3-login-message', 'Web3LoginController@message');
Route::post('web3-login-verify', 'Web3LoginController@verify');


//test
Route::resource('user-trans','UserTransferController');


Route::get('login-verify', 'LoginController@form')->name('login-verify');
Route::post('login-verify', 'LoginController@verify');
