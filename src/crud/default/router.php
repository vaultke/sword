<?php
$item =$generator->getControllerID();
$items=\yii\helpers\Inflector::pluralize($item);
$model = \yii\helpers\StringHelper::basename($generator->modelClass);
echo "<?php\n";
?>
return [
//security={{}} #disable authorization on an endpoint
/**
 * @OA\Get(path="/<?=$items;?>",
 *   summary="Lists all <?= $model ?> models ",
 *   tags={"<?=$model?>"},
 *   @OA\Parameter(description="Page No.",in="query",name="page", @OA\Schema(type="integer")),
 *   @OA\Parameter(description="Page Size",in="query",name="per-page", @OA\Schema(type="integer")),
 *   @OA\Parameter(description="Search",in="query",name="_search", @OA\Schema(type="string")),
 *
 <?php foreach ($generator->getTableSchema()->columns as $data): ?>
 *    @OA\Parameter(description="<?=\yii\helpers\Inflector::camel2words($data->name)?>",in="query",name="_<?=$data->name?>", @OA\Schema(type="<?=$data->type?>")),
<?php endforeach; ?>
 *
 *   @OA\Response(
 *     response=200,
 *     description="Returns a data payload object for all <?=$items?>",
 *      @OA\JsonContent(
 *          @OA\Property(property="dataPayload", type="object",
 *              @OA\Property(property="data", type="array",@OA\Items(ref="#/components/schemas/<?=$model?>")),
 *              @OA\Property(property="countOnPage", type="integer", example="25"),
 *              @OA\Property(property="totalCount", type="integer",example="50"),
 *              @OA\Property(property="perPage", type="integer",example="25"),
 *              @OA\Property(property="totalPages", type="integer",example="2"),
 *              @OA\Property(property="currentPage", type="integer",example="1"),
 *              @OA\Property(property="paginationLinks", type="object",
 *                  @OA\Property(property="first", type="string",example="v1/<?=$_ENV['APP_CONTEXT']?>/<?=$items?>?page=1&per-page=25"),
 *                  @OA\Property(property="previous", type="string",example="v1/<?=$_ENV['APP_CONTEXT']?>/<?=$items?>?page=1&per-page=25"),
 *                  @OA\Property(property="self", type="string",example="v1/<?=$_ENV['APP_CONTEXT']?>/<?=$items?>?page=1&per-page=25"),
 *                  @OA\Property(property="next", type="string",example="v1/<?=$_ENV['APP_CONTEXT']?>/<?=$items?>?page=1&per-page=25"),
 *                  @OA\Property(property="last", type="string",example="v1/<?=$_ENV['APP_CONTEXT']?>/<?=$items?>?page=1&per-page=25"),
 *              ),
 *          )
 *      )
 *   ),
 * )
 */
'GET <?=$items?>'         => '<?=$item?>/index',

/**
 * @OA\Post(
 * path="/<?=$item?>",
 * summary="Creates a new <?=$model?> model ",
 * tags={"<?=$model?>"},
 * @OA\RequestBody(required=true,description="Fill in <?=$item?> data",
 *    @OA\JsonContent(required={<?=$generator->generateRequiredRules()?>},ref="#/components/schemas/<?=$model?>"),
 * ),
 * @OA\Response(
 *    response=201,
 *    description="Data payload",
 *    @OA\JsonContent(
 *       @OA\Property(property="dataPayload", type="object",
 *          @OA\Property(property="data", type="object",ref="#/components/schemas/<?=$model?>"),
 *          @OA\Property(property="toastMessage", type="string", example="<?=$item?> created succefully"),
 *          @OA\Property(property="toastTheme", type="string",example="success"),
 *       )
 *    )
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Data Validation Error",
 *    @OA\JsonContent(
 *       @OA\Property(property="errorPayload", type="object",
 *          @OA\Property(property="errors", type="object", ref="#/components/schemas/<?=$model?>"),
 *          @OA\Property(property="toastMessage", type="string", example="Some data could not be validated"),
 *          @OA\Property(property="toastTheme", type="string",example="danger"),
 *       )
 *    )
 * )
 *),
 */
'POST <?=$item?>'         => '<?=$item?>/create',

/**
 * @OA\Get(path="/<?=$item;?>/{id}",
 *   summary="Displays a single <?=$model?> model",
 *   tags={"<?=$model?>"},
 *   @OA\Parameter(description="<?= $model ?> unique ID to load",in="path",name="id",required=true,@OA\Schema(type="string",)),
 *   @OA\Response(
 *     response=200,
 *     description="Displays a single <?=$model?> model.",
 *      @OA\JsonContent(
 *          @OA\Property(property="dataPayload", type="object", ref="#/components/schemas/<?=$model?>"))
 *      ),
 *   @OA\Response(
 *     response=404,
 *     description="Resource not found",
 *      @OA\JsonContent(
 *           @OA\Property(property="errorPayload", type="object",
 *               @OA\Property(property="statusCode", type="integer", example=404 ),
 *               @OA\Property(property="errorMessage", type="string", example="Not found" )
 *           )
 *      )
 *   ),
 * )
 */
'GET <?=$item?>/{id}'     => '<?=$item?>/view',

/**
* @OA\Put(
*     path="/<?=$item?>/{id}",
*     tags={"<?=$model?>"},
*     summary="Updates an existing <?=$model?> model",
*     @OA\Parameter(description="<?= $model ?> unique ID to load and update",in="path",name="id",required=true,@OA\Schema(type="string",)),
*     @OA\RequestBody(required=true, description="<?=$model?> model data payload to be update",
*        @OA\JsonContent(
*           ref="#/components/schemas/<?=$model?>",
*        ),
*     ),
*    @OA\Response(
*       response=202,
*       description="Data payload",
*       @OA\JsonContent(
*          @OA\Property(property="dataPayload", type="object",
*             @OA\Property(property="data", type="object",ref="#/components/schemas/<?=$model?>"),
*             @OA\Property(property="toastMessage", type="string", example="<?=$item?> updated succefully"),
*             @OA\Property(property="toastTheme", type="string",example="success"),
*          )
*       )
*    ),
*    @OA\Response(
*         response=404,
*         description="Resource not found",
*         @OA\JsonContent(
*           @OA\Property(property="errorPayload", type="object",
*               @OA\Property(property="statusCode", type="integer", example=404 ),
*               @OA\Property(property="errorMessage", type="string", example="Not found")
*           )
*         )
*     ),
* )
*/
'PUT <?=$item?>/{id}'     => '<?=$item?>/update',

/**
* @OA\Delete(path="/<?=$item?>/soft/{id}",
*    tags={"<?=$model?>"},
*    summary="Deletes an existing <?=$model?> model.",
*     @OA\Parameter(description="<?= $model ?> unique ID to delete",in="path",name="id",required=true,@OA\Schema(type="string",)),
*     @OA\Response(
*         response=202,
*         description="<?=$item?> successful deletion",
*         @OA\JsonContent(
*           @OA\Property(property="toastPayload", type="object",
*               @OA\Property(property="toastMessage", type="string", example="<?=$model?> deleted successfully" ),
*               @OA\Property(property="toastTheme", type="string", example="info"),
*               @OA\Property(property="toastOptions", type="object")
*           )
*         )
*     ),
*    @OA\Response(
*         response=404,
*         description="Resource not found",
*         @OA\JsonContent(
*           @OA\Property(property="errorPayload", type="object",
*               @OA\Property(property="statusCode", type="integer", example=404 ),
*               @OA\Property(property="errorMessage", type="string", example="Not found")
*           )
*         )
*     ),
* )
*/
'DELETE <?=$item?>/soft/{id}'  => '<?=$item?>/delete',

/**
* @OA\Patch(path="/<?=$item?>/restore/{id}",
*    tags={"<?=$model?>"},
*    summary="Restores a deleted <?=$model?> model.",
*     @OA\Parameter(description="<?= $model ?> unique ID to restore",in="path",name="id",required=true,@OA\Schema(type="string",)),
*     @OA\Response(
*         response=202,
*         description="<?=$item?> successful restoration",
*         @OA\JsonContent(
*           @OA\Property(property="toastPayload", type="object",
*               @OA\Property(property="toastMessage", type="string", example="<?=$model?> restored successfully" ),
*               @OA\Property(property="toastTheme", type="string", example="info"),
*               @OA\Property(property="toastOptions", type="object")
*           )
*         )
*     ),
*    @OA\Response(
*         response=404,
*         description="Resource not found",
*         @OA\JsonContent(
*           @OA\Property(property="errorPayload", type="object",
*               @OA\Property(property="statusCode", type="integer", example=404 ),
*               @OA\Property(property="errorMessage", type="string", example="Not found")
*           )
*         )
*     ),
* )
*/
'PATCH <?=$item?>/restore/{id}'  => '<?=$item?>/restore',

/**
* @OA\Patch(path="/<?=$item?>/status/{id}",
*    tags={"<?=$model?>"},
*    summary="Changes status of  <?=$model?> model.",
*   @OA\Parameter(description="<?= $model ?> unique ID to change status",in="path",name="id",required=true,@OA\Schema(type="string",)),
*     @OA\RequestBody(
*        required=true,
*        description="Value for status must be an integer",
*        @OA\JsonContent(
*            @OA\Property(property="status", type="integer", example="9" ),
*        ),
*     ),
*     @OA\Response(
*         response=202,
*         description="<?=$item?> successful status change",
*         @OA\JsonContent(
*           @OA\Property(property="toastPayload", type="object",
*               @OA\Property(property="toastMessage", type="string", example="<?=$model?> status changed successfully" ),
*               @OA\Property(property="toastTheme", type="string", example="info"),
*               @OA\Property(property="toastOptions", type="object")
*           )
*         )
*     ),
*    @OA\Response(
*         response=404,
*         description="Resource not found",
*         @OA\JsonContent(
*           @OA\Property(property="errorPayload", type="object",
*               @OA\Property(property="statusCode", type="integer", example=404 ),
*               @OA\Property(property="errorMessage", type="string", example="Not found")
*           )
*         )
*     ),
* )
*/
'PATCH <?=$item?>/status/{id}'  => '<?=$item?>/status',
];


