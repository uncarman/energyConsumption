<?php

namespace App\Service\Utils;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/** 分页服务，补足一些默认值
 */
class PageService extends LengthAwarePaginator
{
    protected $total;

    // overwrite
    public function isNotEmpty(){}

    public function __construct($items, $perPage=20, $currentPage=1, array $options = [])
    {
        $total = count($items);
        $items = array_slice($items, ($currentPage-1)*$perPage, $perPage);

        $path = isset($options["page"]) ? $options["page"] : Paginator::resolveCurrentPath();
        $pageName = isset($options["pageName"]) ? $options["pageName"] : "page";
        parent::__construct($items, $total, $perPage, $currentPage, [
            "path" => $path,
            "pageName" => $pageName
        ]);
    }

    public function setItems($items) {
        $this->items = $items instanceof Collection ? $items : Collection::make($items);
    }
}