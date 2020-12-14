<?php namespace Zipzoft\ID;

use SocialiteProviders\Manager\SocialiteWasCalled;

class SocialiteProviderExtend
{
    /**
     * @param SocialiteWasCalled $event
     */
    public function handle(SocialiteWasCalled $event)
    {
        $event->extendSocialite('zipzoft', Provider::class);
    }
}
