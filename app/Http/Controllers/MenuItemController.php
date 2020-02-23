<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityNotFoundException;
use App\Service\MenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $menuId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $menuId)
    {
        // I skipped Request validation in this case
        try {
            $menuItems = $this->menuService->createMenuItems(
                $menuId,
                $request->all(),
            );
        } catch (EntityNotFoundException $exception) {
            /* We should have more automatic errors handling here (throw exception and handle it) */
            return response()->json(['errors' => 'Menu with id #' . $menuId . ' does not exist.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(
            $menuItems,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $menuId
     * @return \Illuminate\Http\Response
     */
    public function show(int $menuId)
    {
        try {
            $menuItems = $this->menuService->getMenuItems(
                $menuId,
            );
        } catch (EntityNotFoundException $exception) {
            /* We should have more automatic errors handling here (throw exception and handle it) */
            return response()->json(['errors' => 'Menu with id #' . $menuId . ' does not exist.'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(
            $menuItems,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param int $menuId
     * @return JsonResponse
     * @throws EntityNotFoundException
     */
    public function destroy(int $menuId)
    {
        $this->menuService->deleteMenuItems($menuId);

        return response()->json(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
