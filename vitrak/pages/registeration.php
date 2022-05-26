<?php /* Template Name: Registeration Form */ ?>
<?php get_header(); ?>
<?php
if (!is_user_logged_in()) : ?>
	<p>You're already logged in and have no need to create a user profile.</p>
	<?php else :
	while (have_posts()) : the_post(); ?>
		<div id="page-<?php the_ID(); ?>">
		<div id="primary" class="content-area">
		<div class="u-columns col2-set" id="customer_login">
			<main id="main" class="registeration-form">
				<article id="post-13" class="post-13 page type-page status-publish hentry">
					<div class="entry-content">
						<div class="woocommerce">
							<div class="u-column2 col-2 p-3">
								<h2 class="text-center">Register</h2>
								<form method="post" class="register-form">
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="reg_username">Username&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="">				
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="email">Email address&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="email" autocomplete="username" value="">				
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="phone">Phone&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="phone" autocomplete="username" value="">				
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="business_name">Business Name&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="business-name" id="business_name" autocomplete="username" value="">				
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="business_address">Business Address&nbsp;<span class="required">*</span></label>
									<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="business_address" id="business_address" autocomplete="username" value="">				
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="business_type">Business Type&nbsp;<span class="required">*</span></label>
									<span class="business-input"><input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="business_type" id="business_type"></span>
									</p>
									<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
									<label for="password">Password&nbsp;<span class="required">*</span></label>
									<span class="password-input"><input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="password" autocomplete="new-password"></span>
									</p>
									<div class="woocommerce-privacy-policy-text">
									<p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our <a href="https://ecotech.kutethemes.net/privacy-policy/" class="woocommerce-privacy-policy-link" target="_blank">privacy policy</a>.</p>
									</div>
									<p class="woocommerce-form-row form-row">
									<input type="hidden" id="woocommerce-register-nonce" name="woocommerce-register-nonce" value="b973f1cb07"><input type="hidden" name="_wp_http_referer" value="/my-account/?demo=17">	
									<button type="submit" class="woocommerce-Button woocommerce-button button register_submit" name="register" value="Register">Register</button>
									</p>
								</form>
							</div>
						</div>
					</div>
					<!-- .entry-content -->
				</article>
				<!-- #post-## -->
			</main>
		</div>
	</div>
</div>

		</section>
		</div>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>