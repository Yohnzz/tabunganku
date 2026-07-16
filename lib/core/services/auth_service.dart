import 'package:supabase_flutter/supabase_flutter.dart';

class AuthService {
  final SupabaseClient _supabase = Supabase.instance.client;

  // Stream untuk memantau perubahan status auth (login/logout)
  Stream<AuthState> get authStateChanges => _supabase.auth.onAuthStateChange;

  // Mendapatkan user saat ini
  User? get currentUser => _supabase.auth.currentUser;

  // Cek apakah user sedang login
  bool get isLoggedIn => _supabase.auth.currentSession != null;

  // Sign Up / Register
  Future<AuthResponse> signUp({
    required String email,
    required String password,
    required String fullName,
  }) async {
    return await _supabase.auth.signUp(
      email: email,
      password: password,
      data: {'full_name': fullName},
    );
  }

  // Sign In / Login
  Future<AuthResponse> signIn({
    required String email,
    required String password,
  }) async {
    return await _supabase.auth.signInWithPassword(
      email: email,
      password: password,
    );
  }

  // Sign Out / Logout
  Future<void> signOut() async {
    await _supabase.auth.signOut();
  }
}
