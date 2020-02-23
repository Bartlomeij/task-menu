<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Menu;
use App\Service\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * @var MenuService
     */
    private $menuService;

    /**
     * MenuController constructor.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        /* We should also add validation  (like min, max etc) */
        $menu = $this->menuService->createMenu(
            $request->field,
            (int)$request->max_depth,
            (int)$request->max_children,
        );

        /* I could add location header with an address of the new resource here */
        return response()->json(
            $menu->toArray(),
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.yo
     *
     * @param  int  $menuId
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId)
    {
        try {
            $menu = $this->menuService->getMenuById($menuId);
        } catch (EntityNotFoundException $exception) {
            /* We should have more automatic errors handling here (throw exception and handle it) */
            return response()->json(['errors' => 'Menu with id #' . $menuId . ' does not exist.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(
            $menu->toArray(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MenuUpdateRequest  $request
     * @param  int  $menuId
     * @return \Illuminate\Http\Response
     */
    public function update(MenuUpdateRequest $request, int $menuId)
    {
        try {
            $menu = $this->menuService->updateMenu(
                $menuId,
                $request->field,
                (int)$request->max_depth ?? null,
                (int)$request->max_children ?? null,
                );
        } catch (EntityNotFoundException $exception) {
            /* We should have more automatic errors handling here (throw exception and handle it) */
            return response()->json(['errors' => 'Menu with id #' . $menuId . ' does not exist.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(
            $menu->toArray(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $menuId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $menuId)
    {
        $this->menuService->deleteMenuById($menuId);

        return response()->json(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
