<?php

declare(strict_types=1);

namespace App\Lib;

use App\Models\ShopifySession;
use Exception;
use Shopify\Auth\AccessTokenOnlineUserInfo;
use Shopify\Auth\Session;
use Shopify\Auth\SessionStorage;

class DbSessionStorage implements SessionStorage
{
    /**
     * @inheritdoc
     */
    public function loadSession(string $sessionId): ?Session
    {
        $db_session = ShopifySession::where('session_id', $sessionId)->first();

        if ($db_session) {
            $session = new Session(
                $db_session->session_id,
                $db_session->shop,
                $db_session->is_online == 1,
                $db_session->state
            );
            if ($db_session->expires_at) {
                $session->setExpires($db_session->expires_at);
            }
            if ($db_session->access_token) {
                $session->setAccessToken($db_session->access_token);
            }
            if ($db_session->scope) {
                $session->setScope($db_session->scope);
            }
            if ($db_session->user_id) {
                $online_accessInfo = new AccessTokenOnlineUserInfo(
                    (int)$db_session->user_id,
                    $db_session->user_first_name,
                    $db_session->user_last_name,
                    $db_session->user_email,
                    $db_session->user_email_verified == 1,
                    $db_session->account_owner == 1,
                    $db_session->locale,
                    $db_session->collaborator == 1
                );
                $session->setOnlineAccessInfo($online_accessInfo);
            }
            return $session;
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function storeSession(Session $session): bool
    {
        $db_session = ShopifySession::where('session_id', $session->getId())->first();
        if (!$db_session) {
            $db_session = new ShopifySession;
        }
        $db_session->session_id = $session->getId();
        $db_session->shop = $session->getShop();
        $db_session->state = $session->getState();
        $db_session->is_online = $session->isOnline();
        $db_session->access_token = $session->getAccessToken();
        $db_session->expires_at = $session->getExpires();
        $db_session->scope = $session->getScope();
        if (!empty($session->getOnlineAccessInfo())) {
            $db_session->user_id = $session->getOnlineAccessInfo()->getId();
            $db_session->user_first_name = $session->getOnlineAccessInfo()->getFirstName();
            $db_session->user_last_name = $session->getOnlineAccessInfo()->getLastName();
            $db_session->user_email = $session->getOnlineAccessInfo()->getEmail();
            $db_session->user_email_verified = $session->getOnlineAccessInfo()->isEmailVerified();
            $db_session->account_owner = $session->getOnlineAccessInfo()->isAccountOwner();
            $db_session->locale = $session->getOnlineAccessInfo()->getLocale();
            $db_session->collaborator = $session->getOnlineAccessInfo()->isCollaborator();
        }

        return rescue(function () use ($db_session) {
            return $db_session->save();
        }, false);
    }

    /**
     * @inheritdoc
     */
    public function deleteSession(string $sessionId): bool
    {
        return ShopifySession::where('session_id', $sessionId)->delete() === 1;
    }
}
