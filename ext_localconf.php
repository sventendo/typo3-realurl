<?php
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tstemplate.php']['linkData-PostProc']['realurl'] = 'DmitryDulepov\\Realurl\\Encoder\\UrlEncoder->encodeUrl';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['typoLink_PostProc']['realurl'] = 'DmitryDulepov\\Realurl\\Encoder\\UrlEncoder->postProcessEncodedUrl';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['realurl'] = 'DmitryDulepov\\Realurl\\Decoder\\UrlDecoder->decodeUrl';

if (!function_exists('includeRealurlConfiguration')) {
	/**
	 * Includes RealURL configuration.
	 *
	 * @return void
	 */
	function includeRealurlConfiguration() {
		$configuration = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['realurl']);
		if (is_array($configuration)) {
			$realurlConfigurationFile = trim($configuration['configFile']);
			if ($realurlConfigurationFile && @file_exists(PATH_site . $realurlConfigurationFile)) {
				/** @noinspection PhpIncludeInspection */
				require_once(PATH_site . $realurlConfigurationFile);
			}
			unset($realurlConfigurationFile);


			if (!isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']) && $configuration['enableAutoConf']) {
				if (!defined('TX_REALURL_AUTOCONF_FILE')) {
					define('TX_REALURL_AUTOCONF_FILE', 'typo3conf/realurl_autoconf.php');
				}
				/** @noinspection PhpIncludeInspection */
				@include_once(PATH_site . TX_REALURL_AUTOCONF_FILE);
			}
		}
	}

	includeRealurlConfiguration();

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['realurl_all_caches'] = 'DmitryDulepov\\Realurl\\Hooks\\Cache->clearUrlCache';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['realurl_records'] = 'DmitryDulepov\\Realurl\\Hooks\\Cache->clearUrlCacheForRecords';

//	$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_realurl_pathsegment,tx_realurl_exclude,tx_realurl_pathoverride';
//	$GLOBALS['TYPO3_CONF_VARS']['FE']['pageOverlayFields'] .= ',tx_realurl_pathsegment';
}
