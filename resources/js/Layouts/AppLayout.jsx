import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import { House, Users, Bell, UserCircle } from '@phosphor-icons/react';

export default function AppLayout({ children }) {
    const { url } = usePage();

    const navItems = [
        { name: 'Home', href: '/app', icon: House },
        { name: 'Contacts', href: '/app/contacts', icon: Users },
        { name: 'Profile', href: '/settings/profile', icon: UserCircle, external: true },
    ];

    return (
        <div className="min-h-screen bg-zinc-50 dark:bg-black flex flex-col pb-20 md:pb-0">
            {/* Header */}
            <header className="sticky top-0 z-40 w-full bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 px-4 h-16 flex items-center justify-between">
                <div className="flex items-center gap-2">
                    {/* Placeholder for Logo */}
                    <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span className="text-white font-bold text-xl">A</span>
                    </div>
                    <span className="font-bold text-lg dark:text-white hidden sm:block">AfterMeet</span>
                </div>

                <div className="flex items-center gap-4">
                    <button className="p-2 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-full relative">
                        <Bell size={24} />
                        <span className="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-zinc-900"></span>
                    </button>
                </div>
            </header>

            {/* Main Content */}
            <main className="flex-1 w-full max-w-4xl mx-auto px-4 py-6">
                {children}
            </main>

            {/* Mobile Footer Navigation */}
            <nav className="fixed bottom-0 left-0 right-0 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800 h-16 flex items-center justify-around px-2 md:hidden z-50">
                {navItems.map((item) => {
                    const Icon = item.icon;
                    const isActive = url === item.href;
                    
                    if (item.external) {
                        return (
                            <a 
                                key={item.name}
                                href={item.href}
                                className={`flex flex-col items-center justify-center flex-1 h-full gap-1 ${isActive ? 'text-blue-600' : 'text-zinc-500'}`}
                            >
                                <Icon size={24} weight={isActive ? "fill" : "regular"} />
                                <span className="text-[10px] font-medium">{item.name}</span>
                            </a>
                        );
                    }

                    return (
                        <Link 
                            key={item.name}
                            href={item.href}
                            className={`flex flex-col items-center justify-center flex-1 h-full gap-1 ${isActive ? 'text-blue-600' : 'text-zinc-500'}`}
                        >
                            <Icon size={24} weight={isActive ? "fill" : "regular"} />
                            <span className="text-[10px] font-medium">{item.name}</span>
                        </Link>
                    );
                })}
            </nav>

            {/* Desktop Side/Top Nav can be added here if needed, but sticking to mobile-first PWA feel */}
        </div>
    );
}
