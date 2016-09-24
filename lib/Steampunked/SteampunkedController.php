<?php

/**
 * Created by PhpStorm.
 * User: hewhite
 * Date: 2/15/16
 * Time: 12:29 PM
 */

namespace Steampunked;

class SteampunkedController
{
    private $page = 'game.php';
    private $reset = false;         // True if we need to reset the game
    private $model;
    private $checked='';

    protected $result = null;	///< result for AJAX operations

    /**
     * Constructor
     * @param SteampunkedModel $model The SteampunkedModel object
     * @param $post $_POST array
     */
    public function __construct(SteampunkedModel $model, $post) {
        $this->model = $model;

        if (isset($post['player1Name']) && isset($post['player2Name'])) {
            $this->model->setPlayerNames($post['player1Name'],$post['player2Name']);
        }
        if(isset($post['gridSize'])){
            $this->model->setGridSize($post['gridSize']);
        }
        if(isset($post['give-up'])){
            $this->model->setError(false);
            $this->model->giveUp();
//            $this->page = 'winner.php';
            ///
            $view = new SteampunkedView($model);
            $grid = $view->pic();
            $turnMessage = $view->turnMessage();
            $error = $view->getError();
            $pipeOptions ='';
            $winnerOptions = $view->winnerOptions();

            $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => '', 'winnerOptions'=>$winnerOptions));

            //$this->reset = true;
        }
        if(isset($post['discard']) && isset($post['pipe'])){
            $this->model->discardPipe($post['pipe']);
            $this->model->switchTurns();
            //
            $view = new SteampunkedView($model);
            $grid = $view->grid();
            $turnMessage = $view->turnMessage();
            $error = $view->getError();
            $pipeOptions = $view->pipeOptions();
            $winnerOptions = '';
;           $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => $pipeOptions));
        }
        if(isset($post['rotate']) && isset($post['pipe'])){
            $this->model->setError(false);
            $this->model->rotatePipe($post['pipe']);
            //
            $view = new SteampunkedView($model);
            $grid = $view->grid();
            $turnMessage = $view->turnMessage();
            $error = $view->getError();
            $pipeOptions = $view->pipeOptions();
            $winnerOptions ='';
            $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => $pipeOptions));
            $this->checked='checked';
        }
        if(isset($post['open-valve'])){
            $this->model->setError(false);
            if(!$this->model->openValve()) {
                $this->model->giveUp();
            }
            if($this->model->openValve()){
                $this->model->switchTurns();
                $this->model->giveUp();
            }



            //
            $view = new SteampunkedView($model);
            $grid = $view->pic();
            $turnMessage = $view->turnMessage();
            $error = $view->getError();
            $pipeOptions = '';
            $winnerOptions = $view->winnerOptions();
            $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => $pipeOptions, 'winnerOptions'=>$winnerOptions));

            $this->page = 'winner.php';
            //$this->reset = true;
        }
        // Inserting Pipe into the correct tile
        if(isset($post['insert']) && isset($post['pipe'])){
            $index = explode(',', $post['insert']);
            if ($this->model->insertPipe($index[0], $index[1], $post['pipe'])) {
                $this->model->switchTurns();
                $this->model->setError(false);
                //
                $view = new SteampunkedView($model);
                $grid = $view->grid();
                $turnMessage = $view->turnMessage();
                $error = $view->getError();
                $pipeOptions = $view->pipeOptions();
                $winnerOptions = '';
                $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => $pipeOptions));

            }
            else {
                $this->model->setError(true);
            }

        }
        if(isset($post['replay'])){
            $this->model->reset();
            $this->model->setGridSize($this->model->getGridSize());

            $view = new SteampunkedView($model);
            $grid = $view->grid();
            $turnMessage = $view->turnMessage();
            $error = $view->getError();
            $pipeOptions = $view->pipeOptions();
            $winnerOptions = '';
            $this->result = json_encode(array('grid' => $grid, 'turnMessage' => $turnMessage, 'error' => $error,'pipeOptions' => $pipeOptions,'winnerOptions'=>$winnerOptions));

        }
        if(isset($post['new-game'])){
            $this->page = 'index.php';
            $this->reset = true;
            $this->result = json_encode(array('page'=>'index.php'));
        }
        if(isset($post['how-to-play'])){
            $this->page = 'introduction.php';
        }


    }

    /**
     * Get the value of reset
     * @return reset
     */
    public function isReset() {
        return $this->reset;
    }

    /**
     * Get the next page to redirect to
     * @return page
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * Get any ajax response
     * @return JSON result for AJAX
     */
    public function getResult() {
        return $this->result;
    }
    public function getChecked(){
        return $this->checked;
    }


}