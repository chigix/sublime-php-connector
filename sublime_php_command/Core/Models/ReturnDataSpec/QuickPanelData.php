<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Chigi\Sublime\Models\ReturnDataSpec;

use ArrayIterator;
use Chigi\Sublime\Models\BaseModel;
use Chigi\Sublime\Models\BaseReturnData;

/**
 * QuickPanel 列表显示返回数据
 *
 * @author 郷
 */
class QuickPanelData extends BaseReturnData {

    /**
     *
     * @var ArrayIterator
     */
    private $itemCollection;

    public function __initial() {
        $this->itemCollection = new ArrayIterator();
        parent::__initial();
    }

    public function getItemCollection() {
        return $this->itemCollection;
    }
    
    public function pushItem(BaseModel $item) {
        $this->itemCollection->append($item);
        return $this;
    }

}
