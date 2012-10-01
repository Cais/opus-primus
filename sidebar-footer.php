<?php
/**
 * Sidebar Footer Template
 *
 * @package     OpusPrimus
 * @since       0.1
 *
 * @author      Opus Primus <in.opus.primus@gmail.com>
 * @copyright   Copyright (c) 2012, Opus Primus
 *
 * This file is part of Opus Primus.
 *
 * Opus Primus is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @todo Remove / comment out test code
 */

/** Add empty hook before Sidebar-Footer */
do_action( 'opus_primus_before_sidebar_footer' );

/** Only resolve public facing space if there is an active footer widget area. */
if ( is_active_sidebar( 'footer-middle' ) || is_active_sidebar( 'footer-left' ) || is_active_sidebar( 'footer-right' ) ) : ?>

    <div id="footer-sidebar">
        <div class="footer-widget-area three-columns-footer">
            <div class="column-middle">
                <div class="column-left">

                    <ul id="footer-sidebar-two">
                        <?php
                        if ( is_active_sidebar( 'footer-middle' ) ) :
                            dynamic_sidebar( 'footer-middle' );
                        else :
                            echo '<div class="test-text">' . 'Test: Footer Middle Widget AreaHamburger fatback andouille, ball tip bacon t-bone turkey tenderloin. Ball tip shank pig, t-bone turducken prosciutto ground round rump bacon pork chop short loin turkey. Pancetta ball tip salami, hamburger t-bone capicola turkey ham hock pork belly tri-tip. Biltong bresaola tail, shoulder sausage turkey cow pork chop fatback. Turkey pork pig bacon short loin meatloaf, chicken ham hock flank andouille tenderloin shank rump filet mignon. Shoulder frankfurter shankle pancetta. Jowl andouille short ribs swine venison, pork loin pork chop meatball jerky filet mignon shoulder tenderloin chicken pork.<br />' . '</div>';
                        endif; ?>
                    </ul><!-- #footer-sidebar-two -->

                    <ul id="footer-sidebar-one">
                        <?php
                        if ( is_active_sidebar( 'footer-left' ) ) :
                            dynamic_sidebar( 'footer-left' );
                        else :
                            echo '<div class="test-text">' . 'BACON Test: Footer Left Widget AreaHamburger fatback andouille, ball tip bacon t-bone turkey tenderloin. Ball tip shank pig, t-bone turducken prosciutto ground round rump bacon pork chop short loin turkey. Pancetta ball tip salami, hamburger t-bone capicola turkey ham hock pork belly tri-tip. Biltong bresaola tail, shoulder sausage turkey cow pork chop fatback. Turkey pork pig bacon short loin meatloaf, chicken ham hock flank andouille tenderloin shank rump filet mignon. Shoulder frankfurter shankle pancetta. Jowl andouille short ribs swine venison, pork loin pork chop meatball jerky filet mignon shoulder tenderloin chicken pork.<br />' . '</div>';
                        endif; ?>
                    </ul><!-- #footer-sidebar-one -->

                    <ul id="footer-sidebar-three">
                        <?php
                        if ( is_active_sidebar( 'footer-right' ) ) :
                            dynamic_sidebar( 'footer-right' );
                        else :
                            echo '<div class="test-text">' . 'Test: Footer Right Widget AreaHamburger fatback andouille, ball tip bacon t-bone turkey tenderloin. Ball tip shank pig, t-bone turducken prosciutto ground round rump bacon pork chop short loin turkey. Pancetta ball tip salami, hamburger t-bone capicola turkey ham hock pork belly tri-tip. Biltong bresaola tail, shoulder sausage turkey cow pork chop fatback. Turkey pork pig bacon short loin meatloaf, chicken ham hock flank andouille tenderloin shank rump filet mignon. Shoulder frankfurter shankle pancetta. Jowl andouille short ribs swine venison, pork loin pork chop meatball jerky filet mignon shoulder tenderloin chicken pork.<br />' . '</div>';
                        endif; ?>
                    </ul><!-- #footer-sidebar-three -->

                </div><!-- .column-left -->
            </div><!-- .column-middle -->
        </div><!-- .footer-widget-area.three-columns-footer -->
    </div><!-- #footer-sidebar -->

<?php
endif;

/** Add empty hook after Sidebar-Footer */
do_action( 'opus_primus_after_sidebar_footer' );