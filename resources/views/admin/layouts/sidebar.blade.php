<aside class="main-sidebar sidebar-dark-primary admin-sidebar elevation-0">

    <!-- Sidebar -->
    <div class="sidebar">
     <br>
      <!-- Sidebar Menu -->
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column"  data-widget="treeview" role="menu" data-accordion="false">
          {{-- admin dashboard button start --}}
          <li class="nav-item">
            <a href="/admin" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p>
                {{ App\MaintenanceLocale::getLocale(1) }}
              </p>
            </a>
          </li>
          {{-- admin dashboard button end --}}

          {{-- admin employer approval start --}}
          <li class="nav-item has-treeview mt-2">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-briefcase"></i>
               <p>
                {{ App\MaintenanceLocale::getLocale(458) }}
                <i class="fa fa-angle-left right"></i>
               </p>
            </a>
 
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/alljobs" class="nav-link">
                   <p style="float:left">
                    {{ App\MaintenanceLocale::getLocale(459) }}
                   </p>
                   <span class="badge badge-light" style="float:right">{{ $alljobs->count() }}</span>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/allcourses" class="nav-link">
                   <p style="float:left">
                    {{ App\MaintenanceLocale::getLocale(460) }}
                   </p>
                   <span class="badge badge-light" style="float:right">{{ $allcourses->count() }}</span>
                </a>
              </li>
            </ul>
          </li>
           {{-- admin employer approval end --}}
          
          {{-- admin reports end--}}
           <li class="nav-item has-treeview mt-2">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p>
                {{ App\MaintenanceLocale::getLocale(2) }}
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            {{-- sales --}}
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/sales" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(3) }}</p>
                </a>
              </li>
            </ul>

            {{-- list of company --}}
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/companylist" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(4) }}</p>
                </a>
              </li>
            </ul>

            {{-- list of applicants --}}
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/applicantlist" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(5) }}</p>
                </a>
              </li>
            </ul>

            {{-- list of schools --}}
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/schoolslist" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(6) }}</p>
                </a>
              </li>
            </ul>

            {{-- list of organizations --}}
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/organizationlist" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(7) }}</p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/documents" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(42) }}</p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/topsubscriber" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(8) }}</p>
                </a>
              </li>
            </ul>

            {{-- top ratings --}}
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/admin/reports/toprating" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(9) }}</p>
                </a>
              </li>
            </ul>
            
          </li>
          {{-- admin report end --}}

          {{-- admin employer approval start --}}
          <li class="nav-item has-treeview mt-2">
           <a href="#" class="nav-link">
             <i class="nav-icon fa fa-check-circle"></i>
              <p>
               {{ App\MaintenanceLocale::getLocale(171) }} 
               <i class="fa fa-angle-left right"></i>
              </p>
           </a>
           {{-- sales --}}
            <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/approval" class="nav-link">
                  <p style="float:left">
                    {{ App\MaintenanceLocale::getLocale(10) }} 
                  </p>
                  <span class="badge badge-light" style="float:right">{{$num}}</span>
               </a>
             </li>
           </ul>

           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/jobs" class="nav-link">
                  <p style="float:left">
                  {{ App\MaintenanceLocale::getLocale(175) }} 
                  </p>
                  <span class="badge badge-light" style="float:right">{{$pending_job}}</span>
               </a>
             </li>
           </ul>

           <ul class="nav nav-treeview">
             <li class="nav-item">
               <a href="/admin/reviews" class="nav-link">
                  <p style="float:left">
                    {{ App\MaintenanceLocale::getLocale(407) }} 
                  </p>
                  <span class="badge badge-light" style="float:right">{{$pending_rev}}</span>
               </a>
             </li>
           </ul>

           <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/admin/over-the-counter" class="nav-link">
                 <p style="float:left">
                  {{ App\MaintenanceLocale::getLocale(512) }} 
                 </p>
                 <span class="badge badge-light" style="float:right">{{$otcs}}</span>
              </a>
            </li>
          </ul>
         </li>
          {{-- admin employer approval end --}}

          {{-- admin maintenance start --}}
          <li class="nav-item has-treeview mt-2">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                
               {{App\MaintenanceLocale::getLocale(11)}}
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ">
              <li class="nav-item">
                <a href="/admin/subscriptions" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(16)}}</p>
                </a>
                <a href="/admin/faq" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(17)}}</p>
                </a>
                <a href="/admin/maintenance" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(18)}}</p>
                </a>
                <a href="/admin/types" class="nav-link">
                  <p></p>
                  <p>Types</p>
                </a>
                <a href="/admin/results" class="nav-link">
                  <p></p>
                  <p>Type of Skill Evaluation</p>
                </a>
                <a href="/admin/banks" class="nav-link">
                  <p></p>
                  <p>{{ App\MaintenanceLocale::getLocale(522) }} </p>
                </a>
                <a href="/admin/civil" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(19)}}</p>
                </a>
                <a href="/admin/countries" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(20)}}</p>
                </a>
                <a href="/admin/currencies" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(21)}}</p>
                </a>
                <a href="/admin/employment" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(22)}}</p>
                </a>
                <a href="/admin/hobbies" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(23)}}</p>
                </a>
                <a href="/admin/industries" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(24)}}</p>
                </a>
                <a href="/admin/attainment" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(25)}}</p>
                </a>
                <a href="/admin/position" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(26)}}</p>
                </a>
                <a href="/admin/religion" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(27)}}</p>
                </a>
                <a href="/admin/specialization" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(28)}}</p>
                </a>
                <a href="/admin/language" class="nav-link">
                  <p></p>
                  <p>{{App\MaintenanceLocale::getLocale(282)}}</p>
                </a>
              </li>
            </ul>
          </li>
           {{-- admin maintenance end --}}

           {{-- admin users feedback start --}}
          <li class="nav-item has-treeview mt-2">
            <a href="/admin/feedback" class="nav-link">
            <i class="nav-icon fa fa-comments"></i>     
              <p style="">
                {{ App\MaintenanceLocale::getLocale(12) }} 
              </p>
              <span class="badge badge-light"style="padding: 4px 4px; position: absolute; right: 10px; top: 9px;">{{$feedbacks->count()}}</span>
            </a>
          </li>
          {{-- admin users feedback end --}}

          {{-- admin news and articles start --}}
          <li class="nav-item has-treeview mt-2">
            <a href="/admin/blog" class="nav-link">
              <i class="nav-icon fa fa-newspaper-o"></i>
              <p style="">
                {{ App\MaintenanceLocale::getLocale(13) }}
              </p>
              <span class="badge badge-light" style="padding: 4px 4px; position: absolute; right: 10px; top: 9px;">{{$maintenance_blogs->count()}}</span>
            </a>
          </li>

          <li class="nav-item has-treeview mt-2">
            <a href="/admin/featured" class="nav-link">
              <i class="nav-icon fa fa-globe"></i>
              <p style="">
                {{ App\MaintenanceLocale::getLocale(620) }}
              </p>
            </a>
          </li>
          {{-- admin news and articles end --}}

          {{-- admin update notification start --}}
          <li class="nav-item has-treeview mt-2">
            <a href="/admin/systemupdate" class="nav-link">
              <i class="nav-icon fa fa-share"></i>
              <p>
               {{App\MaintenanceLocale::getLocale(15)}}
              </p>
            </a>
          </li>
          {{-- admin update notification end --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>