<?php

function smarty_function_user_followers($params, Smarty_Internal_Template $template) {
    $user_id = isset($params['user_id']) ? $params['user_id'] : 0;

    $ul = '<ul class="thumbnails">%s</ul>';
    $li = '<li class="span2">%s</li>';
    $image = '<a href="%s" class="thumbnail" rel="tooltip" title="%s"><img src="%s" /></a>';

    $em = Zend_Registry::get('doctrine')->getEntityManager();

    $query = $em->createQuery("SELECT u
                               FROM Champs\Entity\User u, Champs\Entity\UserProfile up
                               WHERE up.user = u and u.id = ?1 and up.profile_key = 'activated' and up.profile_value = '1'");
    $query->setFirstResult(0)->setMaxResults(6)->setParameter(1, $user_id);

    $result = $query->getSingleResult();

    require_once $template->smarty->_get_plugin_filepath('function', 'imagefile');

    $userLi = '';

    foreach ($result->followersWithMe as $user) {
        $image_url = smarty_function_imagefile(array('id' => $user->getProfileAlbum()->photos->last()->id, 'w' => 200), $template);
        $user_url = sprintf('/dating/user/%s', $user->username);
        $newImage = sprintf($image, $user_url, $user->username, $image_url);

        $userLi .= sprintf($li, $newImage);
    }

    return sprintf($ul, $userLi);
}