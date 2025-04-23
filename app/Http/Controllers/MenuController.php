<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $menus = Menu::when($search, function ($query, $search) {
            return $query->where('nome', 'like', '%' . $search . '%');
        })->paginate(8);

        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $featherIcons = $this->getFeatherIcons();
        
        return view('menu.create', compact('featherIcons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $data = $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'nullable|string|max:255',
        'icone' => 'nullable|string',
        'rota' => 'nullable|string|max:255', 
        // Remova 'ativo' da validação, já que vamos forçar manualmente
    ]);

    // Força o status como inativo (0)
    $data['ativo'] = 0;

    Menu::create($data);

    return redirect()->route('menus.index')->with('success', 'Menu criado com sucesso!');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $featherIcons = $this->getFeatherIcons();
        return view('menu.edit', compact('menu', 'featherIcons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
{
    // Validar os dados recebidos, incluindo o campo 'ativo'
    $data = $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'nullable|string|max:255',
        'icone' => 'nullable|string',
        'rota' => 'nullable|string|max:255',
        'ativo' => 'nullable|boolean',  // O campo ativo ainda pode ser booleano
    ]);

    // Verificar se o campo 'ativo' foi enviado, se não, definir como 0 (desmarcado)
    $data['ativo'] = $request->has('ativo') ? 1 : 0;

    // Atualizar o menu com os dados validados
    $menu->update($data);

    return redirect()->route('menus.index')->with('success', 'Menu Alterado com sucesso!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->submenus()->exists()) {
            return back()->with('error', 'Não é possível excluir um menu que possui submenus associados.');
        }
    
        $menu->delete();
    
        return back()->with('success', 'Menu excluído com sucesso!');
    }

    /**
     * Retorna a lista de ícones do Feather Icons.
     */
    private function getFeatherIcons()
    {
        return [
            'activity', 'airplay', 'alert-circle', 'alert-octagon', 'alert-triangle',
            'align-center', 'align-justify', 'align-left', 'align-right', 'anchor',
            'aperture', 'archive', 'arrow-down', 'arrow-down-circle', 'arrow-down-left',
            'arrow-down-right', 'arrow-left', 'arrow-left-circle', 'arrow-right',
            'arrow-right-circle', 'arrow-up', 'arrow-up-circle', 'arrow-up-left',
            'arrow-up-right', 'at-sign', 'award', 'bar-chart', 'bar-chart-2', 'battery',
            'battery-charging', 'bell', 'bell-off', 'bluetooth', 'bold', 'book',
            'book-open', 'bookmark', 'box', 'briefcase', 'calendar', 'camera',
            'camera-off', 'cast', 'check', 'check-circle', 'check-square',
            'chevron-down', 'chevron-left', 'chevron-right', 'chevron-up',
            'chevrons-down', 'chevrons-left', 'chevrons-right', 'chevrons-up', 'chrome',
            'circle', 'clipboard', 'clock', 'cloud', 'cloud-drizzle', 'cloud-lightning',
            'cloud-off', 'cloud-rain', 'cloud-snow', 'code', 'codepen', 'codesandbox',
            'coffee', 'columns', 'command', 'compass', 'copy', 'corner-down-left',
            'corner-down-right', 'corner-left-down', 'corner-left-up',
            'corner-right-down', 'corner-right-up', 'corner-up-left', 'corner-up-right',
            'cpu', 'credit-card', 'crop', 'crosshair', 'database', 'delete', 'disc',
            'divide', 'divide-circle', 'divide-square', 'dollar-sign', 'download',
            'download-cloud', 'dribbble', 'droplet', 'edit', 'edit-2', 'edit-3',
            'external-link', 'eye', 'eye-off', 'facebook', 'fast-forward', 'feather',
            'figma', 'file', 'file-minus', 'file-plus', 'file-text', 'film', 'filter',
            'flag', 'folder', 'folder-minus', 'folder-plus', 'framer', 'frown', 'gift',
            'git-branch', 'git-commit', 'git-merge', 'git-pull-request', 'github',
            'gitlab', 'globe', 'grid', 'hard-drive', 'hash', 'headphones', 'heart',
            'help-circle', 'hexagon', 'home', 'image', 'inbox', 'info', 'instagram',
            'italic', 'key', 'layers', 'layout', 'life-buoy', 'link', 'link-2',
            'linkedin', 'list', 'loader', 'lock', 'log-in', 'log-out', 'mail', 'map',
            'map-pin', 'maximize', 'maximize-2', 'meh', 'menu', 'message-circle',
            'message-square', 'mic', 'mic-off', 'minimize', 'minimize-2', 'minus',
            'minus-circle', 'minus-square', 'monitor', 'moon', 'more-horizontal',
            'more-vertical', 'mouse-pointer', 'move', 'music', 'navigation',
            'navigation-2', 'octagon', 'package', 'paperclip', 'pause', 'pause-circle',
            'pen-tool', 'percent', 'phone', 'phone-call', 'phone-forwarded',
            'phone-incoming', 'phone-missed', 'phone-off', 'phone-outgoing',
            'pie-chart', 'play', 'play-circle', 'plus', 'plus-circle', 'plus-square',
            'pocket', 'power', 'printer', 'radio', 'refresh-ccw', 'refresh-cw',
            'repeat', 'rewind', 'rotate-ccw', 'rotate-cw', 'rss', 'save', 'scissors',
            'search', 'send', 'server', 'settings', 'share', 'share-2', 'shield',
            'shield-off', 'shopping-bag', 'shopping-cart', 'shuffle', 'sidebar',
            'skip-back', 'skip-forward', 'slack', 'slash', 'sliders', 'smartphone',
            'smile', 'speaker', 'square', 'star', 'stop-circle', 'sun', 'sunrise',
            'sunset', 'tablet', 'tag', 'target', 'terminal', 'thermometer',
            'thumbs-down', 'thumbs-up', 'toggle-left', 'toggle-right', 'tool', 'trash',
            'trash-2', 'trello', 'trending-down', 'trending-up', 'triangle', 'truck',
            'tv', 'twitch', 'twitter', 'type', 'umbrella', 'underline', 'unlock',
            'upload', 'upload-cloud', 'user', 'user-check', 'user-minus', 'user-plus',
            'user-x', 'users', 'video', 'video-off', 'voicemail', 'volume', 'volume-1',
            'volume-2', 'volume-x', 'watch', 'wifi', 'wifi-off', 'wind', 'x', 'x-circle',
            'x-octagon', 'x-square', 'youtube', 'zap', 'zap-off', 'zoom-in', 'zoom-out'
          ]
          ;
    }
}
