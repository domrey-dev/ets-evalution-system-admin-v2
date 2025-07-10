import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { Card, CardContent } from "@/Components/Card";
import TextInput from "@/Components/TextInput";
import PrimaryButton from "@/Components/PrimaryButton";
import { useState } from "react";
import { 
  MagnifyingGlassIcon,
  PlusIcon,
  UserGroupIcon,
  EyeIcon,
  PencilIcon,
  TrashIcon,
  UserIcon
} from "@heroicons/react/24/outline";
import { ChevronUpIcon, ChevronDownIcon } from "@heroicons/react/16/solid";

export default function Index({ auth, success, departments, queryParams = null }) {
  const [filters, setFilters] = useState({
    search: queryParams?.search || ""
  });

  const handleFilterChange = (name, value) => {
    setFilters(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const clearFilters = () => {
    const clearedFilters = {
      search: ""
    };
    setFilters(clearedFilters);
    
    // Automatically apply cleared filters
    router.get(route("departments.index"), {}, {
      preserveState: true,
      replace: true,
    });
  };

  const applyFilters = () => {
    // Remove empty filters
    const filterData = {};
    Object.keys(filters).forEach(key => {
      if (filters[key]) {
        filterData[key] = filters[key];
      }
    });

    router.get(route("departments.index"), filterData, {
      preserveState: true,
      replace: true,
    });
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      applyFilters();
    }
  };

  const deleteDepartment = (department) => {
    if (!window.confirm(`Are you sure you want to delete the "${department.name}" department?`)) {
      return;
    }
    router.delete(route("department.destroy", department.id));
  };

  return (
    <AuthenticatedLayout
        auth={auth}
      header={
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
          <div>
            <h2 className="text-2xl font-bold text-gray-900">Departments</h2>
            <p className="text-sm text-gray-600 mt-1">
              Manage organizational departments and teams
            </p>
          </div>
          <Link
            href={route("department.create")}
            className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200"
          >
            <PlusIcon className="w-4 h-4 mr-2" />
            New Department
          </Link>
        </div>
      }
    >
      <Head title="Departments" />

      <div className="py-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Success Message */}
          {success && (
            <div className="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
              {success}
            </div>
          )}

          {/* Search and Filters */}
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                {/* <h3 className="text-lg font-semibold text-gray-900 mb-4">Filter Departments</h3> */}
                <div className="flex flex-col lg:flex-row lg:items-end gap-4">
                  <div className="flex-1">
                    <div className="grid grid-cols-1 gap-4">
                      <div className="min-w-0">
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Department Name
                        </label>
                        <TextInput
                          className="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                          defaultValue={queryParams?.search}
                          placeholder="Search departments..."
                          value={filters.search}
                          onChange={(e) => setFilters({...filters, search: e.target.value})}
                          onKeyPress={handleKeyPress}
                        />
                      </div>
                    </div>
                  </div>
                  
                  <div className="hidden lg:block w-px h-16 bg-gray-300 mx-4"></div>
                  
                  <div className="flex flex-row gap-3 lg:flex-shrink-0">
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={clearFilters}
                    >
                      Clear
                    </PrimaryButton>
                    <PrimaryButton
                      className="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200"
                      onClick={applyFilters}
                    >
                      Apply
                    </PrimaryButton>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Content */}
          {departments && departments.length > 0 ? (
            /* Table View */
            <Card>
              <div className="overflow-x-auto">
                <table className="min-w-full divide-y divide-gray-200">
                  <thead className="bg-gray-50">
                    <tr>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                        ID
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Department Name
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Staff Count
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Created By
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                        Created Date
                      </th>
                      <th className="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {departments.map((department) => (
                      <tr key={department.id} className="hover:bg-gray-50">
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                          {department.id}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4">
                          <div className="text-xs sm:text-sm font-medium text-gray-900 truncate">
                            {department.name}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4">
                          <div className="text-xs sm:text-sm text-gray-900 max-w-xs truncate">
                            {department.description || "No description"}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                          <div className="flex items-center">
                            <UserGroupIcon className="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mr-1 sm:mr-2" />
                            <span className="text-xs sm:text-sm text-gray-900">0</span>
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          <div className="truncate max-w-24 sm:max-w-32">
                            {department.createdBy?.name || 'Unknown'}
                          </div>
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                          {department.created_at}
                        </td>
                        <td className="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                          <div className="flex items-center justify-end space-x-1 sm:space-x-2">
                            <Link
                              href={route("department.show", department.id)}
                              className="text-blue-600 hover:text-blue-900 transition-colors"
                              title="View"
                            >
                              <EyeIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </Link>
                            <Link
                              href={route("department.edit", department.id)}
                              className="text-emerald-600 hover:text-emerald-900 transition-colors"
                              title="Edit"
                            >
                              <PencilIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </Link>
                            <button
                              onClick={() => deleteDepartment(department)}
                              className="text-red-600 hover:text-red-900 transition-colors"
                              title="Delete"
                            >
                              <TrashIcon className="w-3 h-3 sm:w-4 sm:h-4" />
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Card>
          ) : (
            /* Empty State */
            <Card className="text-center py-12">
              <CardContent>
                <div className="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                  <PlusIcon className="w-12 h-12 text-gray-400" />
                </div>
                <h3 className="text-lg font-medium text-gray-900 mb-2">No departments found</h3>
                <p className="text-gray-500 mb-6">
                  {filters.search 
                    ? `No departments match "${filters.search}". Try adjusting your search.`
                    : "Get started by creating your first department."
                  }
                </p>
                {!filters.search && (
                  <Link
                    href={route("department.create")}
                    className="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all"
                  >
                    <PlusIcon className="w-4 h-4 mr-2" />
                    Create Department
                  </Link>
                )}
              </CardContent>
            </Card>
          )}
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
