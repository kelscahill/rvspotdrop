<h3 class="m-b"><span>Login page</span></h3>
<p class="no-m-t text-sm">
	Change the login page
</p>
<p>
	<label style="margin-right:10px">
		<input name="<?php echo $this->setting->setting_name; ?>[login_disable]" type="checkbox" <?php if ($this->setting->get_setting('login_disable') == true) echo 'checked="checked" '; ?>> 
		Disable style login page
	</label>
</p>
<div class="box">
	<h4><span>Page</span></h4>
	<div class="box-body b-t hide">
		<p>
			<label>Background image <br>
				<input name="<?php echo $this->setting->setting_name; ?>[login_bg_img]" value="<?php esc_html_e( $this->setting->get_setting('login_bg_img') ); ?>" type="text">
				<button type="button" class="button-secondary upload-btn">Upload</button>
			</label>
		</p>
		<div class="color-picker">
			<p>
				<label>Page background color</label>
				<input name="<?php echo $this->setting->setting_name; ?>[login_bg_color]" value="<?php esc_html_e( $this->setting->get_setting('login_bg_color') ); ?>" type="text" class="widefat color-field" placeholder="#f1f1f1">
			</p>
		</div>
	</div>
	<h4 class="b-t"><span>Login</span></h4>
	<div class="box-body b-t hide">
		<p>
			<label>Logo image <br>
				<input name="<?php echo $this->setting->setting_name; ?>[login_logo]" value="<?php esc_html_e( $this->setting->get_setting('login_logo') ); ?>" type="text">
				<button type="button" class="button-secondary upload-btn">Upload</button>
			</label>
		</p>
		<p>
			<label>background image <br>
				<input name="<?php echo $this->setting->setting_name; ?>[login_left_bg_img]" value="<?php esc_html_e( $this->setting->get_setting('login_left_bg_img') ); ?>" type="text">
				<button type="button" class="button-secondary upload-btn">Upload</button>
			</label>
		</p>
		<p>
			Sub title<br>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_subtitle]" class="widefat" rows="4" placeHolder=""><?php esc_html_e( $this->setting->get_setting('login_subtitle') ); ?></textarea>
			</label>
		</p>
		<div class="color-picker">
			<p>
				<label>Text color</label>
				<input name="<?php echo $this->setting->setting_name; ?>[login_text_color]" value="<?php esc_html_e( $this->setting->get_setting('login_text_color') ); ?>" type="text" class="widefat color-field" placeholder="#f1f1f1">
			</p>
			<p>
				<label>Background color</label>
				<input name="<?php echo $this->setting->setting_name; ?>[login_left_bg_color]" value="<?php esc_html_e( $this->setting->get_setting('login_left_bg_color') ); ?>" type="text" class="widefat color-field" placeholder="#f1f1f1">
			</p>
		</div>
	</div>
	<h4 class="b-t"><span>Form</span></h4>
	<div class="box-body b-t hide">
		<p>
			Login title<br>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_form_login_title]" class="widefat" rows="1" placeHolder=""><?php esc_html_e( $this->setting->get_setting('login_form_login_title') ); ?></textarea>
			</label>
		</p>
		<p>
			Register title<br>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_form_register_title]" class="widefat" rows="1" placeHolder=""><?php esc_html_e( $this->setting->get_setting('login_form_register_title') ); ?></textarea>
			</label>
		</p>
		<p>
			Lost password title<br>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_form_lostpassword_title]" class="widefat" rows="1" placeHolder=""><?php esc_html_e( $this->setting->get_setting('login_form_lostpassword_title') ); ?></textarea>
			</label>
		</p>
		<p>
			Footer <br>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_footer]" class="widefat" rows="1" placeHolder=""><?php esc_html_e( $this->setting->get_setting('login_footer') ); ?></textarea>
			</label>
		</p>
	</div>
	<h4 class="b-t"><span>Custom css</span></h4>
	<div class="box-body b-t hide">
		<p>
			<label>
				<textarea name="<?php echo $this->setting->setting_name; ?>[login_css]" class="widefat" rows="4" placeHolder="a{color: #888}"><?php esc_html_e( $this->setting->get_setting('login_css') ); ?></textarea>
			</label>
		</p>
	</div>
</div>
