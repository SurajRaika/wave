import React from 'react';
import AppLayout from '../Layouts/AppLayout';

export default function Dashboard({ auth }) {
    return (
        <AppLayout>
            <div className="space-y-4">
                <h1 className="text-2xl font-bold dark:text-white">App Dashboard</h1>
                <div className="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <p className="text-zinc-600 dark:text-zinc-400">Welcome back, <span className="text-zinc-900 dark:text-zinc-100 font-semibold">{auth.user.name}</span>!</p>
                    <p className="text-sm text-zinc-500 mt-1">This is your new PWA experience. Your contacts and event history will appear here.</p>
                </div>

                <div className="grid grid-cols-2 gap-4">
                    <div className="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <span className="text-xs text-zinc-500 uppercase font-bold">Total Contacts</span>
                        <p className="text-2xl font-bold dark:text-white">0</p>
                    </div>
                    <div className="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <span className="text-xs text-zinc-500 uppercase font-bold">Recent Events</span>
                        <p className="text-2xl font-bold dark:text-white">0</p>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
