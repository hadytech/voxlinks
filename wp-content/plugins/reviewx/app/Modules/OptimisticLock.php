<?php


namespace ReviewX\Modules;


use ReviewX\Constants\LockForm;
use ReviewX\Constants\Reviewx;

class OptimisticLock
{
    protected static $key = "rx_optimistic_lock_form";
    protected static $version = "rx_optimistic_lock_version";

    public static function currentVersion($formID)
    {
        return \get_option($formID) ?: 0;
    }

    public static function nextVersion($formID)
    {
        $nextVersion = static::currentVersion($formID) + 1;
        \update_option($formID, $nextVersion);

        return $nextVersion;
    }

    public static function input($formID)
    {
        $version = static::currentVersion($formID);
        echo \view('admin.components.optimistic_lock.input', compact('formID','version'));
    }

    public static function validate($form, $data)
    {
        $formID = isset($data[self::$key]) ? $data[self::$key] :  null;
        $version = isset($data[self::$version]) ? intval($data[self::$version]) :  null;
        if ((self::currentVersion($formID) == $version) && ($form == $formID)) {
            return true;
        }
        return false;
    }

    public static function successResponse($formID)
    {
        return [
            'optimistic_lock_form_id' => $formID,
            'optimistic_lock_version' => OptimisticLock::nextVersion($formID)
        ];
    }

    public static function errorResponse($formID)
    {
        wp_send_json([
            'action' => "optimistic_error",
            'form_id' => $formID,
            'message' => __("Settings have been updated from another tab. Please refresh to sync the latest data.", 'reviewx')
        ], 400);
    }
}