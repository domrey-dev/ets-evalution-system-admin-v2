import { usePage, router } from "@inertiajs/react";
import { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function RoleIndex({ auth, roles, flash }) {
    const [showConfirmModal, setShowConfirmModal] = useState(false);
    const [roleToDelete, setRoleToDelete] = useState(null);

    const openDeleteModal = (role) => {
        setRoleToDelete(role);
        setShowConfirmModal(true);
    };

    const confirmDelete = () => {
        router.delete(route("roles.destroy", roleToDelete.id));
        setShowConfirmModal(false);
        setRoleToDelete(null);
    };

    const hasPermission = (permission) => {
        return auth.can ? auth.can[permission] === true : false;
    };

    return (
        <AuthenticatedLayout
            auth={auth}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Roles Management
                </h2>
            }
        >
            <Head title="Roles" />

            {flash?.success && (
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-4">
                    <div className="rounded-md bg-green-100 border border-green-200 p-4 text-green-800 text-sm">
                        {flash.success}
                    </div>
                </div>
            )}

            <div className="py-12">
                <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div className="bg-white shadow rounded-lg overflow-hidden">
                        {/* Header */}
                        <div className="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h3 className="text-xl font-semibold text-gray-900">Roles List</h3>
                        </div>

                        {/* Table */}
                        <div className="p-4 overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                                <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wide">No</th>
                                    <th className="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wide">Name</th>
                                    <th className="px-6 py-3 text-center font-semibold text-gray-600 uppercase tracking-wide">Actions</th>
                                </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-100">
                                {roles.length ? (
                                    roles.map((role, index) => (
                                        <tr key={role.id}>
                                            <td className="px-6 py-4 align-middle">{index + 1}</td>
                                            <td className="px-6 py-4 align-middle font-medium">{role.name}</td>
                                            <td className="px-6 py-4 text-right align-middle">
                                                <div className="flex justify-center space-x-2">
                                                    {hasPermission('role-list') && (
                                                        <button
                                                            onClick={() => router.get(route("roles.show", role.id))}
                                                            className="px-3 py-1 border text-gray-700 bg-gray-100 rounded hover:bg-gray-200"
                                                        >
                                                            Show Permissions
                                                        </button>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={3} className="px-6 py-4 text-center text-gray-500">
                                            No roles found.
                                        </td>
                                    </tr>
                                )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {/* Confirmation Modal */}
            {showConfirmModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div className="bg-white rounded-lg shadow-lg w-full max-w-md">
                        <div className="px-6 py-4">
                            <h3 className="text-lg font-semibold text-gray-900">Delete Role</h3>
                            <p className="mt-2 text-sm text-gray-600">
                                Are you sure you want to delete <strong>{roleToDelete?.name}</strong>? This action cannot be undone.
                            </p>
                        </div>
                        <div className="px-6 py-4 bg-gray-50 flex justify-end space-x-2">
                            <button
                                onClick={confirmDelete}
                                className="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                            >
                                Delete
                            </button>
                            <button
                                onClick={() => setShowConfirmModal(false)}
                                className="px-4 py-2 bg-white border text-gray-700 rounded hover:bg-gray-100 text-sm"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
