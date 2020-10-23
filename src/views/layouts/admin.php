<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use bin\admin\components\API;
use kilyakus\helper\media\Image;
use bin\admin\modules\page\api\Page;

use kilyakus\web\Engine;
use kilyakus\web\helpers\Layout;

$baseUrl = Engine::registerThemeAsset($this)->baseUrl;
$moduleName = $this->context->module->id;
$module = $this->context->module->module->id;
if($module == 'app'){
	$module = 'admin';
}

$page = Page::get('page-admin');

$value = null;

$title = ($page ? ($page->model->attributes['page_id'] ? '' : $page->seo('title',$page->title) . ' ') : '') . $this->title;

if(empty($nav)){
	$nav = [];
}
if($moduleName == 'forum'){
}else{
	foreach(Yii::$app->getModule('admin')->activeModules as $key => $activeModule){
		$activeClass = \bin\admin\components\API::getClass($activeModule->name,'api',$activeModule->name);
		if($moduleName == $activeModule->name){
			$value = Url::toRoute(['/' . $module . '/' . $activeModule->name]);
		}
		$nav[$key] = (object)['url' => Url::to(['/' . $module . '/' . $activeModule->name]), 'title' => Yii::t('easyii/'.$activeModule->name,$activeModule->title), 'icon' => $activeModule->icon, 'badge' => ['count' => $activeModule->notice, 'class' => 'kt-badge kt-badge--info kt-badge--wide']];
		if(class_exists($activeClass) && (method_exists($activeClass, 'api_cats') && count($activeClass::cats()))){
			$url = (
				Url::to() == Url::toRoute(['/' . $module . '/' .$activeModule->name. '/items/index','id' => Yii::$app->controller->actionParams['id']])
			) || (
				Url::to() == Url::toRoute(['/' . $module . '/' .$activeModule->name. '/items/index'])
			) || (
				Url::to() == Url::toRoute(['/' . $module . '/' .$activeModule->name. '/a/index','id' => Yii::$app->controller->actionParams['id']])
			) || (
				Url::to() == Url::toRoute(['/' . $module . '/' .$activeModule->name. '/a/index'])
			) || (
				Url::to() == Url::toRoute(['/' . $module . '/' .$activeModule->name])
			);
			$nav[$key]->children['categories'] = (object)['url' => Url::toRoute(['/' . $module . '/' . $activeModule->name]), 'title' => Yii::t('easyii','Categories'), 'icon' => 'list-alt'];
			foreach($activeClass::cats() as $c => $cat) {
				if(!$cat->parent){
					$nav[$key]->children['categories']->children[] = (object)['url' => Url::toRoute(['/' . $module . '/' .$activeModule->name. '/items/index','id' => $cat->category_id]), 'title' => $cat->title, 'image' => $cat->icon];
				}
			}
		}
	}
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?= Html::csrfMetaTags() ?>
		<title><?= Yii::t('easyii', 'Control Panel') ?> - <?= Yii::t('easyii', Html::encode($this->title)) ?></title>
		<?php $this->head() ?>
	</head>

	<!-- begin::Body -->
	<body style="background-image: url(<?= Image::blur($page->model->image,1920,1080) ?>)" <?= Layout::getHtmlOptions('body') ?>>
		<?php $this->beginBody() ?>
		<?=
        (Engine::getComponent()->layoutOption == Engine::LAYOUT_BOXED) ?
                Html::beginTag('div', ['class' => 'container']) : '';
        ?>
		<!-- begin:: Page -->

		<?= $this->render('@bin/admin/views/elements/header/_header_mobile',['baseUrl' => $baseUrl]) ?>

		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<?= $this->render('@bin/admin/views/elements/header/_header',['baseUrl' => $baseUrl, 'title' => $title]) ?>

					<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
							<div class="kt-container kt-container--fit  kt-container--fluid  kt-grid kt-grid--ver">

								<?= $this->render('@bin/admin/views/elements/blocks/_aside',['baseUrl' => $baseUrl, 'nav' => $nav]) ?>

								<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

									<!-- begin:: Content -->
									<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


										<?= $this->render('@bin/admin/views/_alert') ?>
										
										<?= $content ?>

									</div>

									<!-- end:: Content -->
								</div>
							</div>
						</div>
					</div>

					<?= $this->render('@bin/admin/views/elements/footer/_footer',['baseUrl' => $baseUrl]) ?>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>
		<!-- end::Scrolltop -->

		<!-- begin::Sticky Toolbar -->
		<ul class="kt-sticky-toolbar" style="margin-top: 30px;">
			<li class="kt-sticky-toolbar__item kt-sticky-toolbar__item--brand" data-toggle="kt-tooltip" title="<?= Yii::t('easyii','Flush cache') ?>" data-placement="left">
				<a href="<?= Url::toRoute(['/system/default/flush-cache']) ?>"><i class="fa fa-bolt"></i></a>
			</li>
			<li class="kt-sticky-toolbar__item kt-sticky-toolbar__item--warning" data-toggle="kt-tooltip" title="<?= Yii::t('easyii','Clear assets') ?>" data-placement="left">
				<a href="<?= Url::toRoute(['/system/default/clear-assets']) ?>"><i class="fa fa-trash-alt"></i></a>
			</li>
			<li class="kt-sticky-toolbar__item kt-sticky-toolbar__item--danger" id="kt_sticky_toolbar_chat_toggler" data-toggle="kt-tooltip" title="Chat Example" data-placement="left">
				<a href="javascript://" data-toggle="modal" data-target="#kt_chat_modal"><i class="fa fa-comments"></i></a>
			</li>
		</ul>

		<!-- end::Sticky Toolbar -->

		<!--Begin:: Chat-->
		<div class="modal fade- modal-sticky-bottom-right" id="kt_chat_modal" role="dialog" data-backdrop="false">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="kt-chat">
						<div class="kt-portlet kt-portlet--last">
							<div class="kt-portlet__head">
								<div class="kt-chat__head ">
									<div class="kt-chat__left">
										<div class="kt-chat__label">
											<a href="javascript://" class="kt-chat__title">Jason Muller</a>
											<span class="kt-chat__status">
												<span class="kt-badge kt-badge--dot kt-badge--success"></span> Active
											</span>
										</div>
									</div>
									<div class="kt-chat__right">
										<div class="dropdown dropdown-inline">
											<button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="flaticon-more-1"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-md">

												<!--begin::Nav-->
												<ul class="kt-nav">
													<li class="kt-nav__head">
														Messaging
														<i class="flaticon2-information" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more..."></i>
													</li>
													<li class="kt-nav__separator"></li>
													<li class="kt-nav__item">
														<a href="javascript://" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-group"></i>
															<span class="kt-nav__link-text">New Group</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="javascript://" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-open-text-book"></i>
															<span class="kt-nav__link-text">Contacts</span>
															<span class="kt-nav__link-badge">
																<span class="kt-badge kt-badge--brand  kt-badge--rounded-">5</span>
															</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="javascript://" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-bell-2"></i>
															<span class="kt-nav__link-text">Calls</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="javascript://" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-dashboard"></i>
															<span class="kt-nav__link-text">Settings</span>
														</a>
													</li>
													<li class="kt-nav__item">
														<a href="javascript://" class="kt-nav__link">
															<i class="kt-nav__link-icon flaticon2-protected"></i>
															<span class="kt-nav__link-text">Help</span>
														</a>
													</li>
													<li class="kt-nav__separator"></li>
													<li class="kt-nav__foot">
														<a class="btn btn-label-brand btn-bold btn-sm" href="javascript://">Upgrade plan</a>
														<a class="btn btn-clean btn-bold btn-sm" href="javascript://" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
													</li>
												</ul>

												<!--end::Nav-->
											</div>
										</div>
										<button type="button" class="btn btn-clean btn-sm btn-icon" data-dismiss="modal">
											<i class="flaticon2-cross"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="kt-portlet__body">
								<div class="kt-scroll kt-scroll--pull" data-height="410" data-mobile-height="300">
									<div class="kt-chat__messages kt-chat__messages--solid">
										<div class="kt-chat__message kt-chat__message--success">
											<div class="kt-chat__user">
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/100_12.jpg" alt="image">
												</span>
												<a href="javascript://" class="kt-chat__username">Jason Muller</span></a>
												<span class="kt-chat__datetime">2 Hours</span>
											</div>
											<div class="kt-chat__text">
												How likely are you to recommend our company<br> to your friends and family?
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--right kt-chat__message--brand">
											<div class="kt-chat__user">
												<span class="kt-chat__datetime">30 Seconds</span>
												<a href="javascript://" class="kt-chat__username">You</span></a>
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/300_21.jpg" alt="image">
												</span>
											</div>
											<div class="kt-chat__text">
												Hey there, we’re just writing to let you know that you’ve<br> been subscribed to a repository on GitHub.
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--success">
											<div class="kt-chat__user">
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/100_12.jpg" alt="image">
												</span>
												<a href="javascript://" class="kt-chat__username">Jason Muller</span></a>
												<span class="kt-chat__datetime">30 Seconds</span>
											</div>
											<div class="kt-chat__text">
												Ok, Understood!
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--right kt-chat__message--brand">
											<div class="kt-chat__user">
												<span class="kt-chat__datetime">Just Now</span>
												<a href="javascript://" class="kt-chat__username">You</span></a>
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/300_21.jpg" alt="image">
												</span>
											</div>
											<div class="kt-chat__text">
												You’ll receive notifications for all issues, pull requests!
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--success">
											<div class="kt-chat__user">
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/100_12.jpg" alt="image">
												</span>
												<a href="javascript://" class="kt-chat__username">Jason Muller</span></a>
												<span class="kt-chat__datetime">2 Hours</span>
											</div>
											<div class="kt-chat__text">
												You were automatically <b class="kt-font-brand">subscribed</b> <br>because you’ve been given access to the repository
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--right kt-chat__message--brand">
											<div class="kt-chat__user">
												<span class="kt-chat__datetime">30 Seconds</span>
												<a href="javascript://" class="kt-chat__username">You</span></a>
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/300_21.jpg" alt="image">
												</span>
											</div>
											<div class="kt-chat__text">
												You can unwatch this repository immediately <br>by clicking here: <a href="javascript://" class="kt-font-bold kt-link"></a>
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--success">
											<div class="kt-chat__user">
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/100_12.jpg" alt="image">
												</span>
												<a href="javascript://" class="kt-chat__username">Jason Muller</span></a>
												<span class="kt-chat__datetime">30 Seconds</span>
											</div>
											<div class="kt-chat__text">
												Discover what students who viewed Learn <br>Figma - UI/UX Design Essential Training also viewed
											</div>
										</div>
										<div class="kt-chat__message kt-chat__message--right kt-chat__message--brand">
											<div class="kt-chat__user">
												<span class="kt-chat__datetime">Just Now</span>
												<a href="javascript://" class="kt-chat__username">You</span></a>
												<span class="kt-userpic kt-userpic--circle kt-userpic--sm">
													<img src="<?= $baseUrl ?>/media/users/300_21.jpg" alt="image">
												</span>
											</div>
											<div class="kt-chat__text">
												Most purchased Business courses during this sale!
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="kt-portlet__foot">
								<div class="kt-chat__input">
									<div class="kt-chat__editor">
										<textarea placeholder="Type here..." style="height: 50px"></textarea>
									</div>
									<div class="kt-chat__toolbar">
										<div class="kt_chat__tools">
											<a href="javascript://"><i class="flaticon2-link"></i></a>
											<a href="javascript://"><i class="flaticon2-photograph"></i></a>
											<a href="javascript://"><i class="flaticon2-photo-camera"></i></a>
										</div>
										<div class="kt_chat__actions">
											<button type="button" class="btn btn-brand btn-md  btn-font-sm btn-upper btn-bold kt-chat__reply">reply</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--ENd:: Chat-->
		<?= (Engine::getComponent()->layoutOption == Engine::LAYOUT_BOXED) ? Html::endTag('div') : ''; ?>
		<?php $this->endBody() ?>
	</body>

	<!-- end::Body -->
</html>
<?php $this->endPage() ?>