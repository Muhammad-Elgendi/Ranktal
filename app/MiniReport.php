<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiniReport extends Model
{

    protected $fillable=[];

    protected $casts = [
        'hasTitle' => 'boolean',
        'duplicateTitle' => 'boolean',
        'checkLengthTitle' => 'array',
        'lengthTitle' => 'array',
        'title' => 'array',
        'checkTitle' => 'boolean',
        'checkLengthUrl' => 'boolean',
        'checkSpacesUrl' => 'boolean',
        'checkStatusUrl' => 'boolean',
        'checkUrl' => 'boolean',
        'hasDescription' => 'boolean',
        'duplicateDescription' => 'boolean',
        'hasKeywords' => 'boolean',
        'duplicateKeywords' => 'boolean',
        'hasRobots' => 'boolean',
        'hasViewport' => 'boolean',
        'hasNews_keywords' => 'boolean',
        'duplicateNews_keywords' => 'boolean',
        'metas' => 'array',
        'checkLengthDescription' => 'boolean',
        'checkDescription' => 'boolean',
        'checkTextHtmlRatio' => 'boolean',
        'hasCanonical' => 'boolean',
        'hasLanguage' => 'boolean',
        'hasDocType' => 'boolean',
        'hasEncoding' => 'boolean',
        'hasCountry' => 'boolean',
        'hasCity' => 'boolean',
        'hasIpAddress' => 'boolean',
        'h1' => 'array',
        'h2' => 'array',
        'h3' => 'array',
        'h4' => 'array',
        'h5' => 'array',
        'h6' => 'array',
        'hasH1' => 'boolean',
        'hasH2' => 'boolean',
        'hasH3' => 'boolean',
        'hasH4' => 'boolean',
        'hasH5' => 'boolean',
        'hasH6' => 'boolean',
        'hasManyH1' => 'boolean',
        'hasGoodHeadings' => 'boolean',
        'hasImg' => 'boolean',
        'hasAlt' => 'boolean',
        'hasEmptyAlt' => 'boolean',
        'hasNoAltWithImg' => 'boolean',
        'hasGoodImg' => 'boolean',
        'alt' => 'array',
        'emptyAlt' => 'array',
        'hasIFrame' => 'boolean',
        'hasFrameSet' => 'boolean',
        'hasFrame' => 'boolean',
        'hasAmpLink' => 'boolean',
        'hasOG' => 'boolean',
        'hasTwitterCard' => 'boolean',
        'hasFavicon' => 'boolean',
        'hasMicroData' => 'boolean',
        'hasRDFa' => 'boolean',
        'hasJson' => 'boolean',
        'hasStructuredData' => 'boolean',
        'hasMicroFormat' => 'boolean',
        'hasRobotsFile' => 'boolean',
        'hasSiteMap' => 'boolean',
        'hasFormattedText' => 'boolean',
        'hasFlash' => 'boolean',
        'isIndexAble' => 'boolean',
        'openGraph' => 'array',
        'twitterCard' => 'array',
        'siteMap' => 'array',
        'bItems' => 'array',
        'iItems' => 'array',
        'emItems' => 'array',
        'strongItems' => 'array',
        'URLRedirects' => 'array',
        'redirectStatus' => 'array',
        'aText' => 'array',
        'aHref' => 'array',
        'aRel' => 'array',
        'aStatus' => 'array',
        'isFailed' => 'boolean',
        'isCompleted' => 'boolean'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
