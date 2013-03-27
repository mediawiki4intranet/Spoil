<?php

/**
 * MediaWiki Spoil extension
 * Copyright © 2013 Vitaliy Filippov
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Very simple extension - adds a parser tag that displays both parsed content
 * and its source wrapped in a <pre> tag inside an mw-collapsible div.
 *
 * USAGE:
 * <spoil[ title="Here is the source code..."]>
 * ...WIKITEXT...
 * </spoil>
 */

$wgHooks['ParserFirstCallInit'][] = 'efSpoilParserFirstCallInit';
$wgExtensionMessagesFiles['Spoil'] = __DIR__.'/Spoil.i18n.php';

function efSpoilParserFirstCallInit($parser)
{
    $parser->setHook('spoil', 'efSpoil');
    return true;
}

function efSpoil($text, $args, $parser)
{
    $output = $parser->parse($text, $parser->mTitle, $parser->mOptions, true, false)->getText();
    $title = isset($args['title']) ? $args['title'] : wfMsg('spoil-code');
    return $output .
        '<div class="mw-collapsible mw-collapsed">' .
        '<div style="background: #F0F0F0">&nbsp;'.$title.' </div>' .
        '<pre class="mw-collapsible-content" style="display: none; margin: 0">'.htmlspecialchars($text).'</pre></div>';
}
