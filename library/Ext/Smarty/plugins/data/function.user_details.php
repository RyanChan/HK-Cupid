<?php

function smarty_function_user_details($params, Smarty_Internal_Template $template) {
    $data = isset($params['type']) ? $params['type'] : null;
    $key = isset($params['key']) ? $params['key'] : null;
    $locale = key(Zend_Locale::getDefault());
    $translator = Zend_Registry::get('translate');
    $return = null;

    switch ($data) {
        case 'bloodtype':
            $return = array(
                $translator->_('A Type', $locale),
                $translator->_('B Type', $locale),
                $translator->_('O Type', $locale),
                $translator->_('AB Type', $locale)
            );

            break;
        case 'bodytype':
            $return = array(
                $translator->_('Standard', $locale),
                $translator->_('Symmetry', $locale),
                $translator->_('Plump', $locale),
                $translator->_('Sexy', $locale),
                $translator->_('Slim', $locale),
                $translator->_('Tall', $locale),
                $translator->_('Small', $locale),
                $translator->_('Thin', $locale),
                $translator->_('Fat', $locale),
                $translator->_('Robust', $locale)
            );

            break;
        case 'smoking':
            $return = array(
                $translator->_('Do not smoke, very disgusted smoking', $locale),
                $translator->_('Do not smoke, but not objectionable smoking', $locale),
                $translator->_('Social occasionally smoke', $locale),
                $translator->_('Smoke a few times a week', $locale),
                $translator->_('Daily smoke', $locale),
                $translator->_('Addicted', $locale)
            );

            break;
        case 'drinking':
            $return = array(
                $translator->_('Not drinking', $locale),
                $translator->_('Social need to drinking', $locale),
                $translator->_('In the mood to drinking', $locale),
                $translator->_('Can\'t live without wine', $locale)
            );

            break;
        case 'resting':
            $return = array(
                $translator->_('Early to bed and early to rise', $locale),
                $translator->_('Often night owls', $locale),
                $translator->_('Always earlybird', $locale),
                $translator->_('Occasionally lazy', $locale),
            );

            break;
        case 'cartag':
            $return = array(
                $translator->_('I don\'t have a car', $locale),
                $translator->_('I have a car', $locale),
                $translator->_('I have a car and giving by company', $locale),
                $translator->_('I have more than one cars', $locale)
            );

            break;
        case 'relationship':
            $return = array(
                $translator->_('Single', $locale),
                $translator->_('In Relationship', $locale),
                $translator->_('Married', $locale),
                $translator->_('Complicated', $locale)
            );

            break;
        case 'maxconsume':
            $return = array(
                $translator->_('Food', $locale),
                $translator->_('Clothing', $locale),
                $translator->_('Entertainment', $locale),
                $translator->_('Traveling', $locale),
                $translator->_('Dating', $locale),
                $translator->_('Culture', $locale),
                $translator->_('Education', $locale),
                $translator->_('Others', $locale)
            );

            break;
        case 'romance':
            $return = array(
                $translator->_('Always', $locale),
                $translator->_('Sometimes', $locale),
                $translator->_('Depends on situation', $locale),
                $translator->_('Never', $locale),
                $translator->_('Don\'t like', $locale)
            );

            break;
        case 'house_tag':
            $return = array(
                $translator->_('Live alone', $locale),
                $translator->_('Shared with roommates', $locale),
                $translator->_('Shared with family', $locale),
                $translator->_('Cosmopolitan', $locale)
            );

            break;
        case 'educationlist':
            $return = array(
                $translator->_('Primary School', $locale),
                $translator->_('Secondary School', $locale),
                $translator->_('High School', $locale),
                $translator->_('Bachelor', $locale),
                $translator->_('Master', $locale),
                $translator->_('Doctor', $locale)
            );

            break;
        case 'personalincome':
            $return = array(
                $translator->_('$5000 - $10000', $locale),
                $translator->_('$10000 - $20000', $locale),
                $translator->_('$20000 - $30000', $locale),
                $translator->_('$30000 - $40000', $locale),
                $translator->_('$40000 - $50000', $locale),
            );

            break;
        case 'profession':
            $return = array(
                $translator->_('CEO', $locale),
                $translator->_('Accountant', $locale),
                $translator->_('Lawyer', $locale),
                $translator->_('Doctor', $locale),
                $translator->_('Pilot', $locale),
                $translator->_('Coach', $locale),
                $translator->_('Designer', $locale),
                $translator->_('Engineer', $locale),
                $translator->_('Teacher', $locale),
                $translator->_('Cop', $locale),
                $translator->_('Model', $locale),
                $translator->_('Others', $locale)
            );

            break;
        case 'occupation':
            $return = array(
                $translator->_('Information Technology', $locale),
                $translator->_('Human Resource', $locale),
                $translator->_('Government', $locale),
                $translator->_('Construction', $locale),
                $translator->_('Accounting', $locale),
                $translator->_('Traveling', $locale),
                $translator->_('Law', $locale),
                $translator->_('Medication', $locale),
                $translator->_('Education', $locale),
                $translator->_('Others', $locale)
            );

            break;
        case 'interested_in':
            $return = array(
                $translator->_('Women', $locale),
                $translator->_('Men', $locale),
                $translator->_('Both', $locale)
            );

            break;
        default:
            $return = array();
            break;
    }

    if (!array_key_exists($key, $return))
        return null;

    return $return[$key];
}