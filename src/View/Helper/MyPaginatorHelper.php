<?php 

namespace App\View\Helper;

use Cake\View\Helper\PaginatorHelper;

class MyPaginatorHelper extends PaginatorHelper{

	/**
     * Default config for this class
     *
     * Options: Holds the default options for pagination links
     *
     * The values that may be specified are:
     *
     * - `url` Url of the action. See Router::url()
     * - `url['sort']`  the key that the recordset is sorted.
     * - `url['direction']` Direction of the sorting (default: 'asc').
     * - `url['page']` Page number to use in links.
     * - `model` The name of the model.
     * - `escape` Defines if the title field for the link should be escaped (default: true).
     *
     * Templates: the templates used by this class
     *
     * @var array
     */

	protected $_defaultConfig = [
        'options' => [],
        'templates' => [
            'nextActive' => '<a rel="next" class="icon item" href="{{url}}"><i class="right chevron icon"></i></a>',
            'nextDisabled' => '<a rel="next" class="icon item disabled" href="{{url}}"><i class="right chevron icon"></i></a>',
            'prevActive' => '<a rel="next" class="icon item" href="{{url}}"><i class="left chevron icon"></i></a>',
            'prevDisabled' => '<a rel="next" class="icon item disabled" href="{{url}}"><i class="left chevron icon"></i></a>',
            'counterRange' => '{{start}} - {{end}} of {{count}}',
            'counterPages' => '{{page}} of {{pages}}',
            'first' => '<li class="first"><a href="{{url}}">{{text}}</a></li>',
            'last' => '<li class="last"><a href="{{url}}">{{text}}</a></li>',
            'number' => '<a href="{{url}}" class="item">{{text}}</a>',
            'current' => '<a href="" class="item active">{{text}}</a>',
            'ellipsis' => '<li class="ellipsis">...</li>',
            'sort' => '<a class="ui tiny header" href="{{url}}">{{text}}</a>',
            'sortAsc' => '<a class="ui tiny header" href="{{url}}">{{text}}</a>',
            'sortDesc' => '<a class="ui tiny header" href="{{url}}">{{text}}</a>',
            'sortAscLocked' => '<a class="asc locked" href="{{url}}">{{text}}</a>',
            'sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>',
        ]
    ];
}

?>