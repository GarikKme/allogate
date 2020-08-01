<?php
defined( 'ABSPATH' ) or die();
?>
	
	<?php 
		$socials = get_theme_mod('social_share_links');

		if( !empty($socials) && $socials[0] != 'none' && $socials != 'none') :
	?>

		<div class="social-share">
		
			<span><?php echo esc_html_x('Share:', 'frontend', 'setech'); ?></span>

			<?php
				foreach( $socials as $social ){

					switch( $social ){
						case 'add.this':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='".esc_url( sprintf( 'http://www.addthis.com/bookmark.php?url=%s', get_permalink() ) )."'>";
								echo "<i class='far fa-plus-square'></i>";
							echo "</a>";

							break;
						case 'blogger':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://www.blogger.com/blog-this.g?u=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-blogger-b'></i>";
							echo "</a>";

							break;
						case 'buffer':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://buffer.com/add?text=".get_the_title()."&url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-buffer'></i>";
							echo "</a>";

							break;
						case 'diaspora':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://share.diasporafoundation.org/?title=".get_the_title()."&url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-diaspora'></i>";
							echo "</a>";

							break;
						case 'digg':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://digg.com/submit?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-diaspora'></i>";
							echo "</a>";

							break;
						case 'douban':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://www.douban.com/recommend/?url=".esc_url(get_permalink())."'>";
								echo "<i class='far fa-share-square'></i>";
							echo "</a>";

							break;
						case 'evernote':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://www.evernote.com/clip.action?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-evernote'></i>";
							echo "</a>";

							break;
						case 'getpocket':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://getpocket.com/edit?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-get-pocket'></i>";
							echo "</a>";

							break;
						case 'facebook':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='".esc_url( sprintf( 'https://www.facebook.com/sharer/sharer.php?u=%s', get_permalink() ) )."'>";
								echo "<i class='fab fa-facebook-square'></i>";
							echo "</a>";

							break;
						case 'flipboard':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://share.flipboard.com/bookmarklet/popout?v=2&url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-flipboard'></i>";
							echo "</a>";

							break;
						case 'instapaper':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://www.instapaper.com/edit?url=".esc_url(get_permalink())."'>";
								echo "<i class='far fa-share-square'></i>";
							echo "</a>";

							break;
						case 'line.me':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://lineit.line.me/share/ui?url=".esc_url(get_permalink())."'>";
								echo "<i class='far fa-share-square'></i>";
							echo "</a>";

							break;
						case 'linkedin':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://www.linkedin.com/shareArticle?mini=true&url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-linkedin'></i>";
							echo "</a>";

							break;
						case 'livejournal':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://www.livejournal.com/update.bml?subject=".get_the_title()."&event=".esc_url(get_permalink())."'>";
								echo "<i class='far fa-share-square'></i>";
							echo "</a>";

							break;
						case 'hacker.news':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://news.ycombinator.com/submitlink?u=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-hacker-news-square'></i>";
							echo "</a>";

							break;
						case 'ok.ru':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-odnoklassniki-square'></i>";
							echo "</a>";

							break;
						case 'pinterest':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://pinterest.com/pin/create/button/?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-pinterest-square'></i>";
							echo "</a>";

							break;
						case 'qzone':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=".esc_url(get_permalink())."'>";
								echo "<i class='far fa-share-square'></i>";
							echo "</a>";

							break;
						case 'reddit':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://reddit.com/submit?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-reddit-square'></i>";
							echo "</a>";

							break;
						case 'skype':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://web.skype.com/share?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-skype'></i>";
							echo "</a>";

							break;
						case 'tumblr':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://www.tumblr.com/widgets/share/tool?canonicalUrl=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-tumblr-square'></i>";
							echo "</a>";

							break;
						case 'twitter':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://twitter.com/intent/tweet?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-twitter-square'></i>";
							echo "</a>";

							break;
						case 'vk':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://vk.com/share.php?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-vk'></i>";
							echo "</a>";

							break;
						case 'weibo':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='http://service.weibo.com/share/share.php?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-weibo'></i>";
							echo "</a>";

							break;
						case 'xing':
							echo "<a class='".$social."' title='".ucfirst($social)."' target='_blank' href='https://www.xing.com/spi/shares/new?url=".esc_url(get_permalink())."'>";
								echo "<i class='fab fa-xing-square'></i>";
							echo "</a>";
							
							break;
					}

				} 
			?>

		</div>

	<?php endif; ?>